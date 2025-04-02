<?php
namespace App\Modules\Subscription\Repository;

use App\Modules\Subscription\Models\MasterSubscription;
use App\Modules\Subscription\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SubscriptionRepository {

    public function getFreePlan() {
        try {
            return MasterSubscription::where('name', 'Free Plan')
                ->select('id', 'features')
                ->first();
        } catch (\Exception $e) {
            Log::error("SubscriptionRepository -> getFreePlan -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return false;
        }
    }

    public function getPlan($id) {
        try {
            return MasterSubscription::where('id', $id)
                ->select('id', 'features')
                ->first();
        } catch (\Exception $e) {
            Log::error("SubscriptionRepository -> getFreePlan -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return false;
        }
    }

    public function deactivateActivePlan($userId) {
        try {
            return UserSubscription::where('status', '1')
                ->where('user_id', $userId)
                ->update(['status' => '0']);
        } catch (\Exception $e) {
            Log::error("SubscriptionRepository -> deactivateActivePlan -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return false;
        }
    }

    public function addPlan($userId, $planId, $features) {
        try {
            return UserSubscription::create([
                'user_id' => $userId,
                'subscription_id' => $planId,
                'status' => '1',
                'start_at' => Carbon::now()->toDateTimeString(),
                'end_at' => Carbon::now()->addDays(30)->toDateTimeString(),
                'features' => $features
             ]);
        } catch (\Exception $e) {
            Log::error("SubscriptionRepository -> addPlan -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return false;
        }
    }
}