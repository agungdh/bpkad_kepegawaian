<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skpd extends Model
{
    /** @use HasFactory<\Database\Factories\SkpdFactory> */
    use HasFactory, HasUuid;

    public function bidangs(): HasMany {
        return $this->hasMany(Bidang::class);
    }
}
