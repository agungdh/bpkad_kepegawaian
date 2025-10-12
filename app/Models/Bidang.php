<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    /** @use HasFactory<\Database\Factories\BidangFactory> */
    use HasFactory, HasUuid;

    public function pegawais(): HasMany {
        return $this->hasMany(Pegawai::class);
    }
}
