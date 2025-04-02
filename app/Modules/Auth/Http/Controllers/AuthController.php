<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Request\LoginRequest;
use App\Modules\Auth\Request\RegisterRequest;
use App\Modules\Subscription\Repository\SubscriptionRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Response as StatusCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Register user
     * @param $email, $password
     */
    public function register(RegisterRequest $request)
   {
        DB::beginTransaction();
        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // if user is created then add a free plan
            if($user) {
                $subRepo = new SubscriptionRepository();
                $freePlan = $subRepo->getFreePlan();
                $subRepo->addPlan($user->id, $freePlan->id, $freePlan->features);
            }
            DB::commit();
            return $this->successResponse('You are registered Successfully!');
        } catch (\Exception $e) {
               DB::rollBack();
            Log::error("AuthController -> Register -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Login user
     * @param $email, $password
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            // verify the credentials
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return $this->errorResponse(StatusCode::HTTP_UNAUTHORIZED, 'Unauthorised! Username or Password incorrect!');
            }
            return $this->successResponse('Logged In Successfully!', [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            Log::error("AuthController -> Login -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Logout user
     * @param
     */
    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            return $this->successResponse('Successfully logged out');
        } catch (\Exception $e) {
            Log::error("AuthController -> Logout -> ".$e->getMessage(). ' on line no. '.$e->getLine());
            return $this->errorResponse(
                StatusCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
