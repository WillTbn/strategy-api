<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvestmentPerfomance extends Model
{
    use HasFactory;
    protected $fillable= [
        'investment_id',
        'day',
        'perfomance'
    ];
    protected static function booted():void
    {
        //Para ignora InvestmentPerfomance::withoutGlobalScope('DayNow')->get();
        static::addGlobalScope('DayNow', function(Builder $builder) {
            $dtaNow = Carbon::today();
            $builder->where('day', $dtaNow->day);
        });
    }

    public function investment():HasOne
    {
        return $this->hasOne(Investment::class, 'id', 'investment_id');
    }
    // public function scopeGetDayNow($query)
    // {
    //     $dtaNow = Carbon::today();
    //     return $query->where('day', $dtaNow->day)->get();
    // }
}
