<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/affiliate",
        "/delete/account",
        "flight/payment/success",
        "flight/payment/failed",
        "hotel/payment/success",
        "hotel/payment/failed",
        "bus/payment/success",
        "bus/payment/failed",
    ];
}
