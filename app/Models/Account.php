<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'person',
        'telephone',
        'phone',
        'genre',
        'birthday',
        'avatar',
        'notifications',
        'user_id',
        'condominia_id'
    ];
    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
