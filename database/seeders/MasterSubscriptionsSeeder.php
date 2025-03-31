<?php

namespace Database\Seeders;

use App\Modules\Subscription\Models\MasterSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterSubscriptionsSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Carbon::now()->toDateTimeString();
        $plans = [
            [
                'name' => 'Free Plan',
                'features' => json_encode([
                    'meetings' => [
                        'per_day' => 3
                    ]
                ]),
                'created_at' => $currentTime
            ],
            [
                'name' => 'Basic Plan',
                'features' => json_encode([
                    'meetings' => [
                        'per_day' => 5
                    ]
                ]),
                'created_at' => $currentTime
            ],
            [
                'name' => 'Advance Plan',
                'features' => json_encode([
                    'meetings' => [
                        'per_day' => 7
                    ]
                ]),
                'created_at' => $currentTime
            ],
            [
                'name' => 'Premium Plan',
                'features' => json_encode([
                    'meetings' => [
                        'per_day' => 10
                    ]
                ]),
                'created_at' => $currentTime
            ],
        ];

        foreach($plans as $plan) {
            MasterSubscription::update([
                'name' => $plan['name']
            ], $plan);
        }
    }
}
