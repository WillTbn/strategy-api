<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ability extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function RoleAbilities():BelongsTo
    {
        return $this->belongsTo(RoleAbility::class);
    }
    public function role():HasOne
    {
        return $this->hasOne(Role::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];
}
