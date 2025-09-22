<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_id',
        'provider',
        'amount',
        'status',
        'token_response',
        'callback_response',
        'verified_response',
        'expires_at',
    ];

    protected $casts = [
        'token_response' => 'json',
        'callback_response' => 'json',
        'verified_response' => 'json',
    ];
}
