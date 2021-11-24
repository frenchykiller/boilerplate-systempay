<?php

namespace Frenchykiller\BoilerplateSystempay\View\Composers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Sebastienheyd\Boilerplate\View\Composers\ComponentComposer;

class SystempayComposer extends ComponentComposer
{
    protected $props = [
        'amount',
        'site',
        'currency',
        '3ds',
        'orderId',
        'customer',
        'merchant',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();
        $site = $data['site'] ?? 'default';

        $view->with('token', $this->getToken($site, $data));
        $view->with('key', config("systempay.{$site}.site_id").':'.config("systempay.{$site}.key"));
        $view->with('attributes', $this->attributes);
    }

    private function getToken($site, $data)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Basic'.base64_encode(config("systempay.{$site}.site_id").':'.config("systempay.{$site}.password")),
            'Content-Type' => 'application/json'
        ];
        $body = [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? config("systempay.{$site}.params.currency"),
        ];
        $body = array_merge($body, $data);

        try{
            $response = $client->request('POST', config("systempay.{$site}.url").'Charge/CreatePayment', [
                'headers' => $headers,
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            \Log::info($e->getMessage());
        }
        return json_decode($response->getBody()->getContents())->answer->formToken;
    }
}
