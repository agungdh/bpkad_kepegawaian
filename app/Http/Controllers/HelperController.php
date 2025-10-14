<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function getBidangBySkpd(Request $request, Skpd $skpd) {
        return $skpd->bidangs;
    }
}
