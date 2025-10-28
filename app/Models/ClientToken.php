<?php

namespace App\Models;

use App\Services\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder filters()
 */
class ClientToken extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'sender_name',
        'token',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeQ(Builder $query, string $value): Builder
    {
        return $query->whereLike('sender_name',"%$value%");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
