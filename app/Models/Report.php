<?php

namespace App\Models;

use App\Enum\RoleEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $fillable= [
        'document',
        'title',
        'description',
        'audio',
        'type',
        'user_id',
        'display_date_at'
    ];
    public function user():HasOne
    {
        return $this->hasOne(User::class);
    }
    public function getDocumentAttribute($value)
    {
        return $value != "" ? asset('storage/reports/'.$value): $value;
    }
    public function getAudioAttribute($value)
    {
        if($value)
            return asset('storage/reports/'.$value);
        return null;
    }
    // public function getDisplayDateAtAttribute($value)
    // {
    //     if($value){
    //         $format_date =  Carbon::parse($value);
    //         return  $format_date->format('d/m/Y');
    //     }
    //     return $value;
    // }
    public function scopeClientOrAdmin($query, RoleEnum $role)
    {
        if($role == RoleEnum::Client)
            return $query->where('display_date_at','!=', null)->where('display_date_at', '<', now());
        return $query;
    }
    public function scopeDeleteOnly($query, RoleEnum $role)
    {
        if($role == RoleEnum::Master)
            return $query;
        return $query->where('user_id', auth()->user()->id);
    }
}
