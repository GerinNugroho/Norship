<?php

namespace App\Http\Controllers\API\V1;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\Controller;

class orderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create(Request $request)
    {
        // Kerna perhitungan meleset jadi ya sudahlah
    }
}
