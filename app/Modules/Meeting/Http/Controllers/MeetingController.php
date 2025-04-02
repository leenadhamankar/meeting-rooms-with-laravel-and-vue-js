<?php

namespace App\Modules\Meeting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Meeting\Constants\MeetingConstant;
use App\Modules\Meeting\Models\Meeting;
use App\Modules\Meeting\Request\AddMeetingRequest;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response as StatusCode;
use Illuminate\Support\Facades\Log;

class MeetingController extends Controller
{
    use ApiResponse;

    /**
     * Get all the meeting list created by loggedin user
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        try {
            $currentTime = Carbon::now()->toDateTimeString();
            $filter = ($request->has('latest') && $request->latest == 0) ? MeetingConstant::DATE_FILTER['PAST'] : MeetingConstant::DATE_FILTER['UPCOMING'];
            $data = Meeting::where('user_id', $request->auth_user_id)
                ->where('created_at', $filter, $currentTime)
                ->orderby('id', 'desc')
                ->paginate();
            return $this->successResponse('Meeting list', $data);
        } catch (\Exception $e) {
            Log::error("MeetingController -> Login -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get all the meeting list created by loggedin user
     *
     * @return \Illuminate\Http\Response
     */
    public function add(AddMeetingRequest $request)
    {
        try {
            $name = $request->name;
            $startTime = $request->start_time;
            $duration = $request->duration;
            $endtime = Carbon::createFromDate($startTime)->addMinutes($duration)->toDateTimeString();
            $members = $request->members;
            $roomid = $request->room_id;
            Meeting::create([
                'name' => $name,
                'user_id' => $request->auth_user_id,
                'start_at' => $startTime,
                'end_at' => $endtime,
                'duration' => $duration,
                'members' => $members,
                'meeting_room_id' => $roomid,
            ]);
            return $this->successResponse('Meeting added');
        } catch (\Exception $e) {
            Log::error("MeetingController -> Login -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
