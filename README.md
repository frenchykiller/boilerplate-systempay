# Systempay form component for Laravel 7.x+

![Laravel](https://img.shields.io/badge/Laravel-7.x%20→%208.x-green?logo=Laravel&style=flat-square)
![GitHub](https://img.shields.io/github/license/frenchykiller/boilerplate-systempay?style=flat-square)

## Overview
This package provides a simple component to create a payment form for Banque Populaire's Systempay api.

## Installation
In order to install the Laravel Boilerplate Systempay component, run:
```
composer require frenchykiller/laravel-systempay
```

## Configuration
The component comes with a default config file making the component functional out of the box, however, if you wish to personalize the configuration, you can publish the config file with one of the following commands:
```
php vendor:publish --tag=systempay-config
``` 

By default, the configuration file located at `config/systempay.php` contains the following information:
```php
return [
    'default' => [
        'site_id' => env('SYSTEMPAY_SITE_ID', '73239078'),
        'password' => env('SYSTEMPAY_PASSWORD', 'testpassword_SbEbeOueaMDyg8Rtei1bSaiB5lms9V0ZDjzldGXGAnIwH'),
        'key' => env('SYSTEMPAY_KEY', 'testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ'),
        'url' => 'https://api.systempay.fr/api-payment/V4/',
        'params' => [
            'currency' => 'EUR',
            'formAction' => 'PAYMENT',
            'strongAuthentication' => 'DISABLED',
        ],
    ],
];
```
To change the default configuration, simply set the `SYSTEMPAY_SITE_ID`, `SYSTEMPAY_PASSWORD` and `SYSTEMPAY_KEY` variables in the config file or your .env file. These values are given by Systempay.

If you wish to add extra sites to the same app, simply add new entries to the config file as follows:
```php
return [
    'default' => [
        ...
    ],

    'your_site' => [
        'site_id' => 'your_site_id',
        'password' => 'your_site_password',
        'key' => 'your_site_key',
        'url' => 'https://api.systempay.fr/api-payment/V4/',
        'params' => [
            'currency' => 'USD', //required
            'formAction' => 'PAYMENT',
            'strongAuthentication' => 'ENABLED' //any value other than DISABLED will enabled 3DS2 by default
            //add other static params here
        ],
    ]
```

## Testing
By default the package is set up to run in a test environment. To switch to prod you must set the `SYSTEMPAY_SITE_ID`, `SYSTEMPAY_PASSWORD` and `SYSTEMPAY_KEY` variables in your .env file or publish and change the config file as seen in the [configuration](#configuration) section

## Usage
To include the Systempay form in a page, simply add the component in your blade file:
```php
<x-boilerplate-systempay::systempay amount="2500" />
```

### Attributes
The following attributes are accepted:

| Name | Type | Default | Description |
|---|---|---|---|
|amount|string/int|null|Total amount of the transaction in the currency's smallest unit (Required)|
|currency|string|EUR|Currency to be used for the transaction. A complete list of accepted currencies can be found [here](https://paiement.systempay.fr/doc/en-EN/rest/V4.0/api/playground/Charge/CreatePayment/#currency)|
|site|string|default|The name of the configuration to be used. Can be any name that is specified in the config file|
|strongAuth|string|DISABLED|What mode to use for 3DS (Enabled/Disabled for 3DS1) [details](https://paiement.systempay.fr/doc/en-EN/rest/V4.0/api/playground/Charge/CreatePayment/#strongAuthentication)|
|orderId|string|null|Order reference as defined by the merchant|
|customer|array|null|Customer information such as their billing and/or shipping address. Complete list can be found [here](https://paiement.systempay.fr/doc/en-EN/rest/V4.0/api/playground/Charge/CreatePayment/#customer.email)|
|merchant|array|null|Merchant information such as name, address. Complete list can be found [here](https://paiement.systempay.fr/doc/en-EN/rest/V4.0/api/playground/Charge/CreatePayment/#subMerchantDetails.companyType)|
