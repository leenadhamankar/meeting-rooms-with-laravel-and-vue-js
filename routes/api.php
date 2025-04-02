<?php

use App\Modules\Auth\Http\Controllers\AuthController;
use App\Modules\Meeting\Http\Controllers\MeetingController;
use App\Modules\Meeting\Http\Controllers\MeetingRoomController;
use App\Modules\Subscription\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/login', [AuthController::class, 'login'])
   // ->middleware('throttle:3,1440')
    ->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['ApiAuthenticate']], function () {

    Route::prefix('plan')->group(function () {
        Route::post('/add', [SubscriptionController::class, 'add'])
            ->name('plan.add');
    });

    Route::prefix('meeting')->group(function () {
        Route::post('/list', [MeetingController::class, 'getAll'])
            ->name('meeting.all');
        Route::post('/add', [MeetingController::class, 'add'])
            ->name('meeting.add');

        Route::prefix('rooms')->group(function () {
            Route::get('/list', [MeetingRoomController::class, 'getAll'])
                ->name('meeting.rooms.all');
        });

    });

});