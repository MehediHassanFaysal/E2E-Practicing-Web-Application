<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\CustomerInfo;
use App\Models\NomineeInfo;
use App\Models\SavingsAccountInfo;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerInfoController extends Controller
{
        // Display a listing of the resource
        public function index()
        {
            $customerInfos = CustomerInfo::all();
            return response()->json($customerInfos);
            // return view('customer_info.index', compact('customerInfos'));
        }
    
        // Show the form for creating a new resource
        public function create()
        {
            // Return a view for creating customer info (if needed)
        }
    
        // Store a newly created resource in storage
        public function store(Request $request)
        {
            try {
                // Validate request data
                // $validatedData = $request->validate([
                $validator = Validator::make($request->all(), [
                    'member_code' => 'required|unique:customer_infos|numeric|digits:4',
                    'mobile_number' => [
                                        'required',
                                        'regex:/^(011|013|014|015|016|017|018|019)\d{8}$/',
                                        'numeric'
                                       ],
                    'nation_id_card' => [
                                        'required',
                                        'numeric',
                                        'unique:customer_infos',
                                        'regex:/^\d{10}|\d{13}|\d{17}$/'
                                        ],

                    'dob' => 'required',
                    'occupation' => 'required',
                    'anual_income' => [
                                        'required',
                                        'numeric',
                                        'regex:/^(?:[1-9]\d{3,}|[5-9]\d{2})$/'
                                      ],
                    'present_address' => 'required',
                    'permanent_address' => 'required',
                    'nominee_name' => [
                                        'required',
                                        'string',
                                        'max:255',
                                        'regex:/^[A-Za-z][A-Za-z\s.-]*$/'
                                      ],
                    'age' => [
                                'required',
                                // 'date_format:d/m/Y', // Validates as date
                                'before_or_equal:today' // Ensure the date is not in the future
                             ],
                    'nominee_mobile_number' => [
                                                'required',
                                                'regex:/^(011|013|014|015|016|017|018|019)\d{8}$/',
                                                'numeric'
                                               ],
                    'nid_number' => [
                                        'required',
                                        'string',
                                        'regex:/^\d{10}|\d{13}|\d{17}$/'
                                    ],

                    'birth_id' => [
                                    'nullable',
                                    'string',
                                    'digits:17',
                                    'regex:/^\d{17}$/'
                                  ],

                    'percentage' => [
                                    'required',
                                    'string',
                                    'in:100', // Only allows the value 100
                                ],
                    'relation_with_member' => 'required|string|max:255',
                    'introducer_account' => [
                                                'nullable', // Make it optional if you want
                                                'string', // Ensure it's numeric
                                                'digits:11', // Must be exactly 11 digits
                                                'regex:/^\d{11}$/' // Additional check to ensure it contains only digits
                                            ],

                    'introducer_name' => [
                                            'required',
                                            'string',
                                            'max:255',
                                            'regex:/^[A-Za-z][A-Za-z\s.-]*$/'
                                        ],
                    'introducer_nid' => [
                                            'required',
                                            'string',
                                            'regex:/^\d{10}|\d{13}|\d{17}$/'
                                        ],
                    'introducer_mobile_number' =>  [
                                                        'required',
                                                        'regex:/^(011|013|014|015|016|017|018|019)\d{8}$/',
                                                        'numeric'
                                                    ],
                    'remaks' => 'nullable|string|max:255',
                    'account_type' => [
                                        'required',
                                        'string',
                                        'in:Savings', // Only allows the value 'savings'
                                        'max:255'
                                      ],

                    'amount' => [
                        'required',
                        'numeric',
                        'regex:/^(?:[5-9]\d{2,}|[1-9]\d{3,})$/'
                    ],
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
        
                // Generate the nominee code and account number
                $nomineeCode = NomineeInfo::generateNomineeCode(); 
                $accNo = SavingsAccountInfo::generateSavingAccount(); 
        
                // Create the CustomerInfo record
                $customerInfo = CustomerInfo::create([
                    'member_code' => $request->member_code,
                    'mobile_number' => $request->mobile_number,
                    'nation_id_card'=> $request->nation_id_card,
                    'dob'=> $request->dob,
                    'occupation'=> $request->occupation,
                    'anual_income'=> $request->anual_income,
                    'present_address'=> $request->present_address,
                    'permanent_address'=> $request->permanent_address,
                ]);
                

                // Create the NomineeInfo record
                $customerInfo->nomineeInfo()->create([
                    'nominee_code' => $nomineeCode,
                    'nominee_name' => $request-> nominee_name,
                    'age'=> $request->age,
                    'nominee_mobile_number'=> $request->nominee_mobile_number,
                    'nid_number' => $request->nid_number,
                    'birth_id' => $request->birth_id,
                    'percentage' => $request->percentage,
                    'relation_with_member' => $request->relation_with_member
                ]);

                // Create the IntroducerInfo record
                $customerInfo->introducerInfo()->create([
                    'nominee_code' => $nomineeCode,
                    'introducer_account' => $request-> introducer_account,
                    'introducer_name'=> $request->introducer_name,
                    'introducer_nid'=> $request->introducer_nid,
                    'introducer_mobile_number' => $request->introducer_mobile_number,
                    'remaks' => $request->remaks
                ]);

                // Create the AccountInfo record
                $accountInfo = $customerInfo->accountInfo()->create([
                    'account_number' => $accNo,
                    'account_type' => $request->account_type,
                    'amount' => $request->amount
                ]);

                // Load related information
                $customerInfoWithRelations = $customerInfo->load('nomineeInfo', 'introducerInfo', 'accountInfo');

                // Return success response with account number and other related info
                return response()->json([
                    'message' => "Successful",
                    'info' => $customerInfoWithRelations,
                    // 'account_number' => $accountInfo->account_number
                ], 201); // HTTP response code
        
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Return validation errors
                return response()->json([
                    'error' => 'Validation Error',
                    'message' => $e->validator->errors()
                ], 422);
        
            } catch (\Exception $e) {
                // Return general errors
                return response()->json([
                    'error' => 'Internal Server Error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    
        // Display the specified resource
        public function show($memberCode)
        {
            $customerInfo = CustomerInfo::find($memberCode);
            if (!$customerInfo) {
                return response()->json(['message' => 'Customer info not found'], 404);
            }
            return response()->json($customerInfo);
        }
    
        // Show the form for editing the specified resource
        public function edit($id)
        {
            // Return a view for editing customer info (if needed)
        }
    
        // Update the specified resource in storage
        public function update(Request $request, $id)
        {
            $validatedData = $request->validate([
                'member_code' => 'required|max:255|unique:customer_infos,member_code,' . $id,
                'mobile_number' => 'required',
                'occupation' => 'required',
                'present_address' => 'required',
                'permanent_address' => 'required',
                'nation_id_card' => 'required|max:255|unique:customer_infos,nation_id_card,' . $id,
                'nominee_code' => 'nullable',
                'account_number' => 'required|max:255|unique:customer_infos,account_number,' . $id,
                'account_type' => 'required',
            ]);
    
            $customerInfo = CustomerInfo::find($id);
            if (!$customerInfo) {
                return response()->json(['message' => 'Customer info not found'], 404);
            }
    
            $customerInfo->update($validatedData);
            return response()->json($customerInfo);
        }
    
        // Remove the specified resource from storage
        public function destroy($id)
        {
            $customerInfo = CustomerInfo::find($id);
            if (!$customerInfo) {
                return response()->json(['message' => 'Customer info not found'], 404);
            }
    
            $customerInfo->delete();
            return response()->json(['message' => 'Customer info deleted successfully']);
        }
}
