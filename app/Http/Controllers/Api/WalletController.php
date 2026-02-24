<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    // create a new wallet for a user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::create([
            'user_id' => $validated['user_id'],
            'name' => $validated['name'],
            'balance' => 0,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wallet created successfully',
            'data' => $wallet,
        ], 201);
    }
    /** 
     * Get a specific wallet with balance and transactions
     */

    public function show($id)
    {
        //find  wallet with transactions
        $wallet = Wallet::with('transactions')->find($id);
        if (!$wallet) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet not found',
            ], 404);
}

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $wallet->id,
                'user_id' => $wallet->user_id,
                'name' => $wallet->name,
                'balance' => $wallet->balance,
                'description' => $wallet->description,
                'transactions' => $wallet->transactions,
                'created_at' => $wallet->created_at,
                'updated_at' => $wallet->updated_at,
            ],
        ], 200);
    }
}