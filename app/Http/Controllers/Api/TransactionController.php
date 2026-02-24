<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;

class TransactionController extends Controller
{
    /**
     * Add a transaction to a wallet (income or expense)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'wallet_id' => 'required|exists:wallets,id',  
            'type' => 'required|in:income,expense',       
            'amount' => 'required|numeric|min:0.01',      
            'description' => 'required|string|max:255',
        ]);

        // Create transaction
        $transaction = Transaction::create($validated);    

        // Update wallet balance
        $wallet = Wallet::find($validated['wallet_id']);
        $wallet->updateBalance();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Transaction added successfully',
            'data' => [
                'transaction' => $transaction,
                'wallet_balance' => $wallet->fresh()->balance,
            ],
        ], 201);  
    }
}