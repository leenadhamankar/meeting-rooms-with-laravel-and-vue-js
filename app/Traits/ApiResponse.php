<?php

namespace App\Traits;

use Illuminate\Http\Response as StatusCode;

trait ApiResponse
{
    /**
     * success response method.
     * @param $data result data
     * @param $message {String}
     *
     * @return \Illuminate\Http\Response
     */
    public function successResponse($message = 'OK', $data = '')
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status' => StatusCode::HTTP_OK
        ];

        return response()->json($response, StatusCode::HTTP_OK);
    }

    /**
     * return error response
     * @param $code {Integer} Http status code
     * @param $errorMessage {String} error message
     * @param $error {Array} validation error
     *
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($code, $errorMessage = 'Something Went Wrong!', $error = [])
    {
        $code = ($code) ? $code : StatusCode::HTTP_INTERNAL_SERVER_ERROR;
        $response = [
            'success' => false,
            'message' => $errorMessage,
            'status' => $code,
            'debug' =>  $this->statusCodeMessage($code),
            'errors' => $error
        ];

        return response()->json($response, $code);
    }

    /**
     * Get the error message
     * @param $code {integer}
     * @return $status {String}
     */
    public static function statusCodeMessage($code)
    {
        $status = 'Internal Server Error';

        switch ($code) {
            case 400:
                $status = 'Bad Request';
                break;
            case 401:
                $status = 'Unauthorized Request';
                break;
            case 403:
                $status = 'Forbidden';
                break;
            case 404:
                $status = 'Not Found';
                break;
            case 405:
                $status = 'Method Not Allowed';
                break;
            case 409:
                $status = 'Conflict';
                break;
            case 422:
                $status = 'Unprocessable Entity';
                break;
            case 502:
                $status = 'Service temporarily overloaded';
                break;
            case 503:
                $status = 'Gateway timeout';
                break;
            default:
                $status;
        }

        return $status;
    }
}
