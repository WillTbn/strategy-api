<?php

namespace App\Models;

use App\Enum\RoleEnum;
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
        'user_id'
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
        return $value != "" ? asset('storage/reports/'.$value): $value;
    }
    public function scopeDeleteOnly($query, RoleEnum $role)
    {
        if($role == RoleEnum::Master)
            return $query;
        return $query->where('user_id', auth()->user()->id);
    }
}
