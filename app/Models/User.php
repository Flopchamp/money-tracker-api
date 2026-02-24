<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
    
    ];



   
    /**
     * A user can have many wallets
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Calculate total balance across all user's wallets
     */
    public function getTotalBalanceAttribute()
    {
        return $this->wallets()->sum('balance');
    }
}