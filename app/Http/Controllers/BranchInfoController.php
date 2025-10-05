<?php

namespace App\Http\Controllers;

use App\Models\BranchInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BranchInfoController extends Controller
{
    // Create or Update Branch_info
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_code' => 'required|string|max:255|unique:branch_infos,branch_code,' . $request->id,
            'branch_name' => 'required|string|max:255', // Ensure this matches your database column
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $branchInfo = BranchInfo::create([
            'branch_code' => $request->branch_code,
            'branch_name' => $request->branch_name,
        ]);

        return response()->json([
            'message' => 'Record updated/created successfully.',
            'data' => $branchInfo
        ]);
    }

    // List all Branch_info records
    public function index()
    {
        $branchInfos = BranchInfo::all();
        return response()->json($branchInfos);
    }

    // Show a specific Branch_info record
    public function show($id)
    {
        $branchInfo = BranchInfo::findOrFail($id);
        return response()->json($branchInfo);
    }

    // Delete a specific Branch_info record
    public function destroy($id)
    {
        $branchInfo = BranchInfo::findOrFail($id);
        $branchInfo->delete();

        return response()->json(['message' => 'Record deleted successfully.']);
    }

        // Query by branch name
        public function findByName(Request $request)
        {
            $branchCode = $request->query('branch_code');
            
            // Find the branch by name
            $branchInfo = BranchInfo::where('branch_code', 'like', '%' . $branchCode . '%')->get();
    
            if ($branchInfo->isEmpty()) {
                return response()->json(['message' => 'No branch code found'], 404);
            }
    
            return response()->json($branchInfo);
        }
}
