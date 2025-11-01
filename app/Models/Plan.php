<?php

namespace App\Models;

use App\Services\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder filters()
 */
class Plan extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'token_quota',
        'sms_quota',
        'voice_quota',
        'months_duration',
        'price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->whereLike('title', "%$title%");
    }

    public function scopeMonthsDuration(Builder $query, string $monthsDuration): Builder
    {
        return $query->where('months_duration', $monthsDuration);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
