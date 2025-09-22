<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'mobile',
        'firstname',
        'lastname',
        'national_id',
        'birthdate',
    ];

    protected $with = [
        'roles',
        'subscription',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function clientTokens(): HasMany
    {
        return $this->hasMany(ClientToken::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->latest('id');
    }
}
