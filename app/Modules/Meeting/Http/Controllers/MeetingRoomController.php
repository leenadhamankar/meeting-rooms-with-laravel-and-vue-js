<?php

namespace App\Modules\Meeting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meeting\Models\MeetingRoom;
use App\Traits\ApiResponse;
use Illuminate\Http\Response as StatusCode;
use Illuminate\Support\Facades\Log;

class MeetingRoomController extends Controller
{
    use ApiResponse;

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            $data = MeetingRoom::orderBy('name', 'asc')
                ->get()
                ->toArray();
            return $this->successResponse('Meeting room list', $data);
        } catch (\Exception $e) {
            Log::error("MeetingRoomController -> getAll -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
