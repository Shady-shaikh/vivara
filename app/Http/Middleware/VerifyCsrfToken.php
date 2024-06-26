<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'cart/paymentsuccess',
        'cart/paymentfailure',
        '/handleZohoBooksWebhook',
        '/products/payment_failure',
        '/products/payment_success',
    ];
}
