<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    use HasFactory, HasUuid;

    protected $hidden = [
        'bidang_id',
        'user_id',
    ];

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
