<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'token_quota',
        'sms_quota',
        'duration_months',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
