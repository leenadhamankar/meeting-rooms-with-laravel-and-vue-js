<?php

namespace App\Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Subscription\Repository\SubscriptionRepository;
use App\Modules\Subscription\Request\PurchaseRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as StatusCode;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    use ApiResponse;
    
    public $subRepo;

    public function __construct(SubscriptionRepository $subRepo)
    {
        $this->subRepo = $subRepo;
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function add(PurchaseRequest $request)
    {
        DB::beginTransaction();
        try {
            $planId = $request->plan_id;
            $plan = $this->subRepo->getPlan($planId);
            $this->subRepo->deactivateActivePlan($request->auth_user_id);
            $this->subRepo->addPlan($request->auth_user_id, $plan->id, $plan->features);
            DB::commit();
            return $this->successResponse('Plan is upgraded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("AuthController -> Login -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
