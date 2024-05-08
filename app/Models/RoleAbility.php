<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleAbility extends Model
{
    use HasFactory;
    public function abilities():BelongsTo
    {
        return $this->belongsTo(Ability::class, 'id', 'ability_id');
    }
    public function roles(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
