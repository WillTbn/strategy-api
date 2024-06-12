<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserExtract extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'transaction_name',
        'transaction_date',
        'transaction_data',
        'transaction_value'
    ];
    public function user():HasOne
    {
        return $this->hasOne(User::class);
    }
}
