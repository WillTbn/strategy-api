<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\RoleEnum;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role_id' => RoleEnum::class
        ];
    }
    public function scopeClientOrAdmin($query, RoleEnum $role)
    {
        // if($role == RoleEnum::Client)
        return $query->with(['account', 'userWallet', 'userBankAccounts']);
        // return $query->with(['account']);
    }
    public function scopeVerifyUser($query, RoleEnum $role)
    {
        if($role == RoleEnum::Master)
            return $query->whereNot('id', Auth::user('api')->id)->whereNot('role_id', RoleEnum::Client);
        return $query->whereNot('id', Auth::user('api')->id)->whereNot('role_id', RoleEnum::Master);
    }
    public function sendPasswordResetNotification($token)
    {
        $url = env('APP_URL_FRONT', 'http://localhost:9010/').'login?tokenRemenber='.$token;
        $this->notify(new ResetPasswordNotification($url));
    }
    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }
    public function role():HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    public function reports():HasMany
    {
        return $this->hasMany(Report::class);
    }
    public function userWallet():HasOne
    {
        return $this->hasOne(UserWallet::class);
    }
    public function userBankAccounts():HasMany
    {
        return $this->hasMany(UserBankAccount::class);
    }
    public function accessToken():HasOne
    {
        return $this->hasOne(AccessToken::class);
    }
    public function emailVerifiedUser():HasOne
    {
        return $this->hasOne(EmailVerifiedUser::class);
    }
    public function userInvestments():HasMany
    {
        return $this->hasMany(UserInvestment::class);
    }
    public function isClient():bool
    {
        return $this->role_id == 3;
    }
}
