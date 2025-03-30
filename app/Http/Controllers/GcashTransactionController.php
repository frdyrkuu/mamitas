<?php

namespace App\Http\Controllers;

use App\Models\GcashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GcashTransactionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference_number' => 'required|string|max:255',
            'sender_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'ticket_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $transaction = GcashTransaction::create([
                'reference_number' => $request->reference_number,
                'sender_name' => $request->sender_name,
                'amount' => $request->amount,
                'ticket_number' => $request->ticket_number ?? 'N/A', // Default value
                'transaction_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $transaction
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getValues(){
        $gcash = GcashTransaction::All();

        
        return view('history', [
            'gcash' => $gcash  // Add this line
        ]);
    }
}