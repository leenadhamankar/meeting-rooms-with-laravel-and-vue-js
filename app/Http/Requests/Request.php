<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponse;


abstract class Request extends FormRequest
{
    use ApiResponse;

    /**
     * {@inheritdoc}
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->errorResponse(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY, 'Form Validation Error', $validator->errors()->toArray());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
