<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserWallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'current_balance',
        'current_investment',
        'last_month',
        'current_loan'
    ];
    public function DepositReceipts():HasMany
    {
        return $this->hasMany(DepositReceipt::class, 'user_wallet_id', 'id');
    }
    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
