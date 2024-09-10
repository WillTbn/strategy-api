<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserInvestment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'investment_id'
    ];
    public function users():BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
    public function investment():HasOne
    {
        return $this->hasOne(Investment::class, 'id', 'investment_id');
    }
}
