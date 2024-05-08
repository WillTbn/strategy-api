<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
