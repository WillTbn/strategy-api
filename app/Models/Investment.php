<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Investment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'active'
    ];
    public function userInvestments():BelongsTo
    {
        return $this->belongsTo(UserInvestment::class);
    }
    public function investmentPerformances():HasMany
    {
        return $this->hasMany(InvestmentPerfomance::class);
    }
}
