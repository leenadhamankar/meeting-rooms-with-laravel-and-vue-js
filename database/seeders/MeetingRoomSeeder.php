<?php

namespace Database\Seeders;

use App\Modules\Meeting\Models\MeetingRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeetingRoomSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Carbon::now()->toDateTimeString();
        $rooms = [
            [
                'name' => 'Meeting Room 1',
                'capacity' => 3,
                'created_at' => $currentTime
            ],
            [
                'name' => 'Meeting Room 2',
                'capacity' => 10,
                'created_at' => $currentTime
            ],
            [
                'name' => 'Meeting Room 3',
                'capacity' => 15,
                'created_at' => $currentTime
            ],
            [
                'name' => 'Meeting Room 4',
                'capacity' => 2,
                'created_at' => $currentTime
            ],
            [
                'name' => 'Meeting Room 5',
                'capacity' => 1,
                'created_at' => $currentTime
            ],
        ];

        foreach($rooms as $room) {
            DB::table('meeting_rooms')->update([
                'name' => $room['name']
            ], $room);
        }
    }
}
