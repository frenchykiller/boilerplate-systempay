<?php

return [

    'url' => 'https://api.systempay.fr/api-payment/V4/',
    'params' => [
        'currency' => 'EUR',
        'formAction' => 'PAYMENT',
        'strongAuthentication' => 'DISABLED',
    ],

    'default' => [
        'site_id' => env('SYSTEMPAY_SITE_ID', 'SITE_ID'),
        'password' => env('SYSTEMPAY_PASSWORD', 'SITE_PASSWORD'),
        'key' => env('SYSTEMPAY_KEY', 'SITE_KEY'),
        'env' => env('SYSTEMPAY_ENV', 'TEST'),
    ],
];
