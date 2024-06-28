<?php

namespace App\Models;

use App\Enum\StatusDeposit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DepositReceipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_wallet_id',
        'value',
        'image',
        'status',
        'transaction_id',
        'transaction_code',
        'qrcode'
    ];
    protected function casts():array
    {
        return[
            'status' => StatusDeposit::class
        ];
    }
    public function userWallet(): HasOne
    {
        return $this->hasOne(UserWallet::class, 'id', 'user_wallet_id');
    }
}
