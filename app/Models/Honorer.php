<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Honorer extends Model
{
    /** @use HasFactory<\Database\Factories\HonorerFactory> */
    use HasFactory,HasUlids;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
