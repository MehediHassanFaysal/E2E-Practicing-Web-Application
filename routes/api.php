<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerInfoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BranchInfoController;
use App\Http\Controllers\AcInfoController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login'])->name('login');
// Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected routes with Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    // Add other protected routes here
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout');
    Route::get('/users', [ApiAuthController::class, 'index']);
    Route::get('/view_admin_user',[ApiAuthController::class, 'getAdminInfo']);
    Route::get('/view_user_info',[ApiAuthController::class, 'getUserInfo']);
    Route::get('/admins/{id}', [ApiAuthController::class, 'getAdminById']);
    Route::get('/users/{id}', [ApiAuthController::class, 'getUserById']);
    Route::get('/users/{id}/edit', [ApiAuthController::class, 'editUser']);
    Route::put('/users/{id}', [ApiAuthController::class, 'updateUser']);
    // Route to handle the delete request
    Route::delete('/users/{id}', [ApiAuthController::class, 'destroy'])->name('users.destroy');
    // Route::get('/profile', [ApiAuthController::class, 'showProfile'])->name('view.user.profile');
    Route::post('/cash-deposit-transfer', [TransactionController::class, 'submitCashDepositApi'])->name('cash-deposit.store');
    Route::get('/fund-transaction-history/{account_no}', [TransactionController::class, 'getFundTransactionHistoryByAccountNo']);
    Route::get('/simple-transaction-history/{account_no}', [TransactionController::class, 'getSimpleTransactionHistoryByAccountNo']);
    Route::get('/simple-withdraw-transaction-history/{account_no}', [TransactionController::class, 'getWithdrawTransactionHistoryByAccountNo']);

});

Route::apiResource('customer-info', CustomerInfoController::class);
Route::get('/cash-withdraw/{member_code}', [TransactionController::class, 'cashWithdrawApi']);
Route::get('/cash-deposit/{member_code}', [TransactionController::class, 'cashDepositApi']);




Route::get('/landing-page', [UserController::class, 'redirectToUserLandingPage']);

// In routes/api.php (for API)
Route::get('/user/tokens', [ApiAuthController::class, 'showTokens'])->middleware('auth:sanctum');





Route::get('/branch-info', [BranchInfoController::class, 'index']);
Route::post('/branch-info', [BranchInfoController::class, 'update']);
Route::get('/branch-info/{id}', [BranchInfoController::class, 'show']);
Route::delete('/branch-info/{id}', [BranchInfoController::class, 'destroy']);
Route::get('/branch', [BranchInfoController::class, 'findByName']);



Route::get('/ac-infos', [AcInfoController::class, 'index']);
Route::post('/ac-infos', [AcInfoController::class, 'update']);
Route::get('/ac-infos/{id}', [AcInfoController::class, 'show']);
Route::delete('/ac-infos/{id}', [AcInfoController::class, 'destroy']);

