<?php

namespace App\Models;

use App\Services\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static Builder filters()
 */
class ClientToken extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'signature',
        'token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeQ(Builder $query, string $value): Builder
    {
        return $query->whereLike('signature', "%$value%");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastUsed(): HasOne
    {
        return $this->hasOne(OtpLog::class, 'client_token_id')->latest('id');
    }
}
