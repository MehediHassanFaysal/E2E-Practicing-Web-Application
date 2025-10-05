<?php

namespace App\Http\Controllers;

use App\Models\AcInfo;
use Illuminate\Http\Request;

class AcInfoController extends Controller
{
    // Create or Update Ac_info
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'ac_no' => 'required|string|max:255',
            'branch_code' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        // Create or update the record
        $acInfo = AcInfo::updateOrCreate(
            ['ac_no' => $validatedData['ac_no']],
            $validatedData
        );

        return response()->json([
            'message' => 'Record updated successfully.',
            'data' => $acInfo
        ]);
    }

    // List all Ac_info records
    public function index()
    {
        $acInfos = AcInfo::with('branch')->get(); // Eager load branch info
        return response()->json($acInfos);
    }

    // Show a specific Ac_info record
    public function show($id)
    {
        $acInfo = AcInfo::with('branch')->findOrFail($id);
        return response()->json($acInfo);
    }

    // Delete a specific Ac_info record
    public function destroy($id)
    {
        $acInfo = AcInfo::findOrFail($id);
        $acInfo->delete();

        return response()->json(['message' => 'Record deleted successfully.']);
    }
}

