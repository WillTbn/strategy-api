<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'id'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function RoleAbilities():HasMany
    {
        return $this->hasMany(RoleAbility::class);
    }
    // public function roleAbilities():BelongsToMany
    // {

    //     return $this->belongsToMany(RoleAbility::class);
    // }
    public function  users():HasMany
    {
        return $this->hasMany(User::class);
    }
    public function abilities():BelongsToMany
    {
        return $this->belongsToMany(Ability::class, 'role_abilities');
    }
}
