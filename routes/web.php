<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\CustomerInfoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('login');})->name('home');

Route::get('register', function () {
    return view('auth.register');
});

// Route::get('/landingpage', function () {
//     return view('auth.landingPage');
// })->name('landing_page');



Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected route
Route::middleware('auth')->group(function () {
    Route::get('/landingpage', function () {return view('auth.landingPage');})->name('landing_page');

    Route::get('forgot-password', function () { return view('auth.forgotPassword');});

    // Route::get('/landing-page', [UserController::class, 'showLandingPage']);
    Route::get('/user-profile', [TransactionController::class, 'profileUpdateWeb'])->name('userProfile');



    Route::post('logout', function () {
        Auth::logout();
        return redirect('/'); // Redirect to the home page
    })->name('logout');


    // Admin
    Route::get('/view-admin',[ApiAuthController::class, 'fetchAdminInfo'])->name('landingPage');
    Route::get('/users/{id}/edit', [ApiAuthController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [ApiAuthController::class, 'update'])->name('users.update');
    Route::get('/profile', [ApiAuthController::class, 'showProfile'])->name('view.user.profile');

    Route::get('/landing-page', [TransactionController::class, 'cashDepositWeb'])->name('cash.deposit');
    Route::get('/cash-withdraw', [TransactionController::class, 'cashWithdrawWeb'])->name('cash.withdraw');
    Route::post('/cash-deposit-transfer', [TransactionController::class, 'submitCashDeposit'])->name('cash-deposit.store');
    Route::post('/cash-withdraw-transfer', [TransactionController::class, 'submitCashWithdraw'])->name('cash-withdraw.store');
    Route::get('/fund-transfer', [TransactionController::class, 'redirectToFundTransferPage'])->name('fund.transfer');
    Route::post('/fund-transfer-submit', [TransactionController::class, 'submitFundTransfer'])->name('fund-transfer.store');
    Route::get('/fund-transaction-history', [TransactionController::class, 'redirectToFundTransactionHistoryPage'])->name('fund-transaction.history');
    Route::get('/simple-transaction-history', [TransactionController::class, 'redirectToSimpleTransactionHistoryPage'])->name('simple-transaction.history');
    Route::get('/simple-withdraw-transaction-history', [TransactionController::class, 'redirectToSimpleWithdrawTransactionHistoryPage'])->name('simple-withdraw-transaction.history');

});

// Route::get('/profile', function () {
//     return view('auth.profile');
// })->name('profile_route_name');

Route::resource('customer-info', CustomerInfoController::class);


Route::get('/user/tokens', [ApiAuthController::class, 'showTokens'])->middleware('auth');



Route::get('/forgot', function () {
    return view('auth.forgotPage');
});


Route::post('/send-otp', 'OtpController@sendOtp')->name('send.otp');
Route::post('/verify-otp', 'OtpController@verifyOtp')->name('verify.otp');
