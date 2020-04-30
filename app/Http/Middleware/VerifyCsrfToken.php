<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "driversignup",
        "driversignin",
        "driveruploadprofile",
        "driverupdate",
        "driverlogout",
        'ridersignup',
        'ridersignin',
        'rideruploadprofile',
        'riderlogout',
        'riderupdate',
        'getriderLocation',
        'getdriver',
        'stripe_pay',
        'cancelbooking',
        'createstripe',
        'chargestripe',
        'payoutstripe',
        'createstripeaccount',
        'checkstatus',
        'authstatuschang',
        'acceptrequest',
        'getorderdata',
        'stripepaydriver',
        'completeride'
    ];
}
