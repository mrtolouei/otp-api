<?php

namespace App\Models;

use App\Services\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static Builder filters()
 */
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes, Filterable;

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

    public function scopeMobile(Builder $query, string $mobile): Builder
    {
        return $query->whereLike('mobile', "%$mobile%");
    }

    public function scopeFullname(Builder $query, string $fullname): Builder
    {
        return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$fullname}%"]);
    }

    public function scopeNationalId(Builder $query, string $nationalId): Builder
    {
        return $query->whereLike('national_id', "%$nationalId%");
    }

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
