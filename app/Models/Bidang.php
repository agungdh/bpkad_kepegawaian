<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    /** @use HasFactory<\Database\Factories\BidangFactory> */
    use HasFactory, HasUuid;
}
