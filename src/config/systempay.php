<?php

return [
    'default' => [
        'site_id' => env('SYSTEMPAY_SITE_ID', '73239078'),
        'password' => env('SYSTEMPAY_PASSWORD', 'testpassword_SbEbeOueaMDyg8Rtei1bSaiB5lms9V0ZDjzldGXGAnIwH'),
        'key' => env('SYSTEMPAY_KEY', 'testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ'),
        'env' => env('SYSTEMPAY_ENV', 'TEST'),
        'url' => 'https://api.systempay.fr/api-payment/V4/',
        'params' => [
            'currency' => 'EUR',
            'formAction' => 'PAYMENT',
            'strongAuthentication' => 'NO_PREFERENCE', //Setting this to DISABLED will let the card issuer decide whether 3DS2 is required or not. This will also remove any payment guarantee for the merchant.
            'transactionOptions' => [
                'cardOptions' => [
                    'paymentSource' => 'EC', //Setting this to CC (Call Center) will disable all 3DS checks. This will also shift liability for chargebacks to the merchant.
                ],
            ],
        ],
    ],
];
