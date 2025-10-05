<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SavingsAccountInfo;
use App\Models\TransactionHistory;
use App\Models\CustomerInfo;
use App\Models\FundTransaction;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB; // For Query Builder

class TransactionController extends Controller
{
    public function cashWithdrawApi(Request $request, $member_code)
    {
        /*
        // Validate the request to ensure the user ID is provided
        // $validatedData = $request->validate([
        //     'id' => 'required|string|exists:users,id',
        // ]);

        // // Fetch the user by ID using Eloquent
        // $user = User::find($member_code);
        // // Fetch the user by member_code
        // $user = User::where('member_code', $member_code)->first();
        // Fetch the user by ID using Query Builder
        $user = DB::table('users')->where('member_code', $member_code)->first(['name', 'member_code']);

        if ($user) {
            // Access user data
            $username = $user->name;
            $memberCode = $user->member_code;

            // Return the data or perform other logic
            return response()->json([
                'username' => $username,
                'member_code' => $memberCode,
            ]);
        } else {
            // Handle case when user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
*/
        // Fetch user and customer info by joining tables
        $userInfo = DB::table('users')
            ->join('customer_infos', 'users.member_code', '=', 'customer_infos.member_code')
            ->join('savings_account_infos', 'users.member_code', '=', 'savings_account_infos.member_code')
            ->where('users.member_code', $member_code)
            ->first([
                'users.name',
                'users.member_code', 
                'customer_infos.mobile_number',
                'customer_infos.nation_id_card',
                'savings_account_infos.account_number',
                'savings_account_infos.account_type',
                'savings_account_infos.amount'
            ]);

        if ($userInfo) {
            return response()->json([
                'username' => $userInfo->name,
                'member_code' => $userInfo->member_code,
                'mobile_number' => $userInfo->mobile_number,
                'nation_id_card' => $userInfo->nation_id_card,
                'account_number' => $userInfo->account_number,
                'account_type' => $userInfo->account_type,
                'amount' => $userInfo->amount,
            ]);
        } else {
            return response()->json(['error' => 'User or related information not found.'], 404);
        }
    }

    public function cashDepositApi(Request $request, $member_code)
    {
        // Fetch user and customer info by joining tables
        $userInfo = DB::table('users')
            ->join('customer_infos', 'users.member_code', '=', 'customer_infos.member_code')
            ->join('savings_account_infos', 'users.member_code', '=', 'savings_account_infos.member_code')
            ->where('users.member_code', $member_code)
            ->first([
                'users.name',
                'users.member_code', 
                'customer_infos.mobile_number',
                'customer_infos.nation_id_card',
                'savings_account_infos.account_number',
                'savings_account_infos.account_type',
                'savings_account_infos.amount'
            ]);

        if ($userInfo) {
            return response()->json([
                'name' => $userInfo->name,
                'member_code' => $userInfo->member_code,
                'mobile_number' => $userInfo->mobile_number,
                'nation_id_card' => $userInfo->nation_id_card,
                'account_number' => $userInfo->account_number,
                'account_type' => $userInfo->account_type,
                'amount' => $userInfo->amount,
            ]);
        } else {
            return response()->json(['error' => 'User or related information not found.'], 404);
        }
    }

    public function cashDepositWeb(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); // Get current session ID

        // Fetch user and customer info by joining tables
        $userInfo = DB::table('users')
            ->join('customer_infos', 'users.member_code', '=', 'customer_infos.member_code')
            ->join('savings_account_infos', 'users.member_code', '=', 'savings_account_infos.member_code')
            ->where('users.member_code', $loginUser->member_code)
            ->first([
                'users.name',
                'users.member_code', 
                'customer_infos.mobile_number',
                'customer_infos.nation_id_card',
                'savings_account_infos.account_number',
                'savings_account_infos.account_type',
                'savings_account_infos.amount'
            ]);

        if ($userInfo) {
           return view('auth.userLandingPage', compact('loginUser', 'userInfo', 'sessionId'));
        } else {
            // return redirect()->route('cash.deposit')->withErrors(['error' => 'User information not found.']);
            return view('auth.userLandingPage', compact('loginUser', 'userInfo', 'sessionId'));
        
        }
    }

    public function cashWithdrawWeb(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 

        // Fetch user and customer info by joining tables
        $userInfo = DB::table('users')
            ->join('customer_infos', 'users.member_code', '=', 'customer_infos.member_code')
            ->join('savings_account_infos', 'users.member_code', '=', 'savings_account_infos.member_code')
            ->where('users.member_code', $loginUser->member_code)
            ->first([
                'users.name',
                'users.member_code', 
                'customer_infos.mobile_number',
                'customer_infos.nation_id_card',
                'savings_account_infos.account_number',
                'savings_account_infos.account_type',
                'savings_account_infos.amount'
            ]);

        if ($userInfo) {
           return view('auth.userCashWithdraw', compact('loginUser', 'userInfo', 'sessionId'));
        } else {
            // return redirect()->route('cash.deposit')->withErrors(['error' => 'User information not found.']);
            return view('auth.userCashWithdraw', compact('loginUser', 'userInfo', 'sessionId'));
        
        }
    }
    public function submitCashDepositApi(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'account_number' => [
                                    'required', // Make it optional if you want
                                    'numeric', // Ensure it's numeric
                                    'digits:11', // Must be exactly 11 digits
                                    'regex:/^\d{11}$/' // Additional check to ensure it contains only digits
                                ],
            'amount' => [
                            'required',
                            'numeric',
                            'regex:/^(?:[5-9]\d{2,}|[1-9]\d{3,})$/'
                        ],
            'transaction_type' => 'string',
            'transaction_code' => 'string',
            'remarks' => 'string|max:500'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Generate the nominee code and account number
        $transactionCode = TransactionHistory::generateTransactionCode(); 

        // Create a new user
        $cashDepositTransaction = TransactionHistory::create([
            'account_number' => $request-> account_number,
            'amount' => $request->amount,
            'transaction_type' => $request->transaction_type,
            'transaction_code' => $transactionCode,
            'remarks' => $request->remarks,
        ]);

        // Return a response
        return response()->json(['message' => 'Cash Deposit Transaction successful', 
                                 'transaction_info' => $cashDepositTransaction
                                ], 201);
    }
    public function submitCashDeposit(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        // Validate the request
        $validator = Validator::make($request->all(), [
            'account_number' => [
                            'required', // Make it optional if you want
                            'numeric', // Ensure it's numeric
                            'digits:11', // Must be exactly 11 digits
                            'regex:/^\d{11}$/' // Additional check to ensure it contains only digits
                        ],
            'amount' => [
                            'required',
                            'numeric',
                            'regex:/^(?:[5-9]\d{2,}|[1-9]\d{3,})$/',
                            'max:20000', // Ensure deposit amount does not exceed 20,000
                            'min:500'
                        ],
            'transaction_type' => 'string|in:w,d',
            'transaction_code' => 'string',
            'remarks' => 'string|max:500'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Fetch the account info
        $account = SavingsAccountInfo::where('account_number', $request->account_number)->first();

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        // Update the amount
        $currentBalance = $account->amount;
        $depositAmount = $request->amount;
        $newBalance = $currentBalance + $depositAmount;

        // Update the balance in the savings_account_infos table
        $account->amount = $newBalance;
        $account->save();

        // Generate the nominee code and account number
        $transactionCode = TransactionHistory::generateTransactionCode(); 


        // Create a new user
        $cashDepositTransaction = TransactionHistory::create([
            'account_number' => $request-> account_number,
            'amount' => $request->amount,
            'transaction_type' => $request->transaction_type,
            'transaction_code' => $transactionCode,
            'remarks' => $request->remarks,
        ]);

        //  return view('auth.userLandingPage', compact('loginUser', 'sessionId'));
        // Return JSON response
        return response()->json([
            'message' => 'Cash Deposit Transaction successful!',
            'session_id' => $sessionId // Include session_id if needed
        ], 200);

    }

    public function submitCashWithdraw(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'account_number' => [
                'required', // Make it optional if you want
                'numeric', // Ensure it's numeric
                'digits:11', // Must be exactly 11 digits
                'regex:/^\d{11}$/' // Additional check to ensure it contains only digits
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^(?:[5-9]\d{2,}|[1-9]\d{3,})$/',
                'max:10000', // Ensure withdrawal amount does not exceed 10,000
                'min:500'    // Ensure withdrawal amount is at least 500
            ],
            'transaction_type' => 'string|in:w,d',
            'transaction_code' => 'string',
            'remarks' => 'string|max:500'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Fetch the account info
        $account = SavingsAccountInfo::where('account_number', $request->account_number)->first();

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        // Check if withdrawal conditions are met
        $currentBalance = $account->amount;
        $withdrawalAmount = $request->amount;
        $newBalance = $currentBalance - $withdrawalAmount;

        if ($currentBalance < 500 || $newBalance < 500) {
            return response()->json(['error' => 'Insufficient funds for withdrawal'], 422);
        }

        // Update the amount
        $account->amount = $newBalance;
        $account->save();

        // Generate the nominee code and account number
        $transactionCode = TransactionHistory::generateTransactionCode(); 

        // Create a new transaction
        $cashWithdrawTransaction = TransactionHistory::create([
            'account_number' => $request->account_number,
            'amount' => $withdrawalAmount,
            'transaction_type' => $request->transaction_type,
            'transaction_code' => $transactionCode,
            'remarks' => $request->remarks,
        ]);
        
        // Return JSON response
        return response()->json([
            'message' => 'Cash Withdrawal Transaction successful!',
            'session_id' => $sessionId // Include session_id if needed
        ], 200);
    }

    public function profileUpdateWeb(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 

        // Fetch user and customer info by joining tables
        $userInfo = DB::table('users')
            ->join('customer_infos', 'users.member_code', '=', 'customer_infos.member_code')
            ->join('savings_account_infos', 'users.member_code', '=', 'savings_account_infos.member_code')
            ->join('nominee_infos', 'users.member_code', '=', 'nominee_infos.member_code')
            ->join('introducer_infos', 'users.member_code', '=', 'introducer_infos.member_code')
            ->where('users.member_code', $loginUser->member_code)
            ->first([
                'users.name',
                'users.member_code', 

                'customer_infos.mobile_number',
                'customer_infos.dob',
                'customer_infos.occupation',
                'customer_infos.nation_id_card',
                'customer_infos.anual_income',
                'customer_infos.present_address',
                'customer_infos.permanent_address',

                'nominee_infos.nominee_name',
                'nominee_infos.age',
                'nominee_infos.nominee_mobile_number',
                'nominee_infos.nid_number',
                'nominee_infos.birth_id',
                'nominee_infos.percentage',
                'nominee_infos.relation_with_member',

                'introducer_infos.introducer_account',
                'introducer_infos.introducer_name',
                'introducer_infos.introducer_nid',
                'introducer_infos.introducer_mobile_number',
                'introducer_infos.remaks',

                'savings_account_infos.account_number',
                'savings_account_infos.account_type',
                'savings_account_infos.amount'
            ]);

        if ($userInfo) {
           return view('auth.userProfile', compact('loginUser', 'userInfo', 'sessionId'));
        } else {
            // return redirect()->route('cash.deposit')->withErrors(['error' => 'User information not found.']);
            return view('auth.userProfile', compact('loginUser', 'userInfo', 'sessionId'));
        
        }
    }



    public function redirectToFundTransferPage(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        // Fetch user and customer info by joining tables
        $userInfo = DB::table('users')
            ->join('customer_infos', 'users.member_code', '=', 'customer_infos.member_code')
            ->join('savings_account_infos', 'users.member_code', '=', 'savings_account_infos.member_code')
            ->where('users.member_code', $loginUser->member_code)
            ->first([
                'users.name',
                'users.member_code', 

                'savings_account_infos.account_number',
                'savings_account_infos.account_type',
                'savings_account_infos.amount'
            ]);
        return view('auth.userFundTransfer', compact('loginUser', 'userInfo', 'sessionId'));

    }
    public function submitFundTransfer(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            "receiver_account_number" => [
                'required',
                'string',
                'regex:/^(?:[5-9]\d{2,}|[1-9]\d{3,})$/',
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^(?:[5-9]\d{2,}|[1-9]\d{3,})$/',
                'max:10000', // Ensure withdrawal amount does not exceed 10,000
                'min:500'    // Ensure withdrawal amount is at least 500
            ],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Fetch the account info - sender
        $senderAccount = SavingsAccountInfo::where('account_number', $request->sender_account_number)->first();

        if (!$senderAccount) {
            return response()->json(['error' => 'Sender Account not found'], 404);
        }

        // Check if withdrawal conditions are met - sender
        $currentBalance = $senderAccount->amount;
        $withdrawalAmount = $request->amount;
        $newBalance = $currentBalance - $withdrawalAmount;

        if ($currentBalance < 500 || $newBalance < 500) {
            return response()->json(['error' => 'Insufficient funds for fund transfer-w'], 422);
        }

        // Update the amount - sender
        $senderAccount->amount = $newBalance;
        $senderAccount->save();

        // Fetch the account info - receiver
        $receiverAccount = SavingsAccountInfo::where('account_number', $request->receiver_account_number)->first();

        if (!$receiverAccount) {
            return response()->json(['error' => 'Receiver Account not found'], 404);
        }

        // Check if deposit conditions are met - receiver
        $currentBalance01 = $receiverAccount->amount;
        $dAmount = $request->amount;
        $newBalance01 = $currentBalance01 + $dAmount;

        // Update the amount - receiver
        $receiverAccount->amount = $newBalance01;
        $receiverAccount->save();
        
        // Create a new transaction -receiver
        $cashWithdrawTransaction = FundTransaction::create([
            'sender_account_number' => $request->sender_account_number,
            'receiver_account_number' => $request->receiver_account_number,
            'amount' => $withdrawalAmount
            
        ]);
        
        // Return JSON response
        return response()->json([
            'message' => 'Fund Transaction successful!',
            'session_id' => $sessionId // Include session_id if needed
        ], 200);
    }

    public function redirectToFundTransactionHistoryPage(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        return view('auth.fundTransactionHistory', compact('loginUser', 'sessionId'));
    }
    public function getFundTransactionHistoryByAccountNo (Request $request, $account_no){
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
  
        // Validate if the logged-in user is allowed to access the account
        // Example check: Ensure the user has access to this account
        $account = FundTransaction::where('sender_account_number', $account_no)->first();
    
        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }
    
        // Optionally, validate if the logged-in user is associated with the account
        // For example, assuming `account_number` should belong to the user in some way
        // if ($account->user_id !== $loginUser->id) {
        //     return response()->json(['error' => 'Unauthorized access.'], 403);
        // }
    
        // Fetch all fund transactions related to the given account number
        $transactions = FundTransaction::where('sender_account_number', $account_no)->get();
    
        // Return the transactions as a JSON response
        return response()->json([
            'status' => 'success',
            'transactions' => $transactions
        ]);
    }
    public function redirectToSimpleTransactionHistoryPage(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        return view('auth.normalTransactionHistory', compact('loginUser', 'sessionId'));
    }
    public function getSimpleTransactionHistoryByAccountNo (Request $request, $account_no){
        $loginUser = Auth::user();
        $sessionId = $request->query('session_id');
  
        // Validate if the logged-in user is allowed to access the account
        // Example check: Ensure the user has access to this account
        $account = TransactionHistory::where('account_number', $account_no)->first();
    
        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }
    
        // Optionally, validate if the logged-in user is associated with the account
        // For example, assuming `account_number` should belong to the user in some way
        // if ($account->user_id !== $loginUser->id) {
        //     return response()->json(['error' => 'Unauthorized access.'], 403);
        // }
    
        // Fetch all fund transactions with transaction_type 'd' related to the given account number
        $transactions = TransactionHistory::where('account_number', $account_no)
                                      ->where('transaction_type', 'd') // Filtering for transaction_type 'd'
                                      ->get();
    
        // Return the transactions as a JSON response
        return response()->json([
            'status' => 'success',
            'transactions' => $transactions,
            'session_id' => $sessionId
        ]);
    }
    public function redirectToSimpleWithdrawTransactionHistoryPage(Request $request)
    {
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        return view('auth.withdrawTransactionHistory', compact('loginUser', 'sessionId'));
    }
    public function getWithdrawTransactionHistoryByAccountNo(Request $request, $account_no){
        $loginUser = Auth::user();
        $sessionId = session()->getId(); 
        $account = TransactionHistory::where('account_number', $account_no)->first();
        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }
        $transactions = TransactionHistory::where('account_number', $account_no)
                                      ->where('transaction_type', 'w') // Filtering for transaction_type 'w'
                                      ->get();
        return response()->json([
            'status' => 'success',
            'transactions' => $transactions,
            'session_id' => $sessionId
        ]);
    }
}
