<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccessToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'expires_at',
        'user_id'
    ];
    protected function casts(): array
    {
        return [
            'token'
        ];
    }
    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
