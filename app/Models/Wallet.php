<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use  HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'description',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    /**
     * A wallet belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A wallet has many transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /** Calculate wallet balance from all transactions */
    public function calculateBalance()
    {
        $income = $this->transactions()
        ->where('type', 'income')
        ->sum('amount');

        $expense = $this->transactions()
        ->where('type', 'expense')
        ->sum('amount');
        return $income - $expense;
    }

    /** Update the wallet balance after transactions */
    public function updateBalance()
    {
        $this->balance = $this->calculateBalance();
        $this->save();
    }
}