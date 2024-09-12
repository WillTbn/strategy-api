<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank',
        'agency',
        'number',
        'nickname',
        'main_account',
        'user_id'
    ];
    public function scopeOrderByMainAccount($query)
    {
        return $query->orderBy('main_account', 'desc');
    }
}
