<?php

namespace Frenchykiller\LaravelSystempay\View\Components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\Component;

class Systempay extends Component
{
    protected $props = [
        'amount',
        'site',
        'currency',
        'strong-auth',
        'strongAuth',
        'order-id',
        'orderId',
        'customer',
        'merchant',
    ];

    public int $amount;
    public string $token;
    public string $key;

    private string $site;
    private array $data = array();

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravel-systempay::components.systempay');
    }

    /**
     * Create a new component instance.
     *
     * @param int $amount
     * @param mixed $currency
     * @param string $orderId
     * @param array customer
     * @param array merchant
     * @param string $site
     *
     * @return void
     */
    public function __construct($amount, $currency = null, $orderId = null, $customer = null, $merchant = null, $site = 'default')
    {
        $this->amount = $amount;
        $this->site = $site;
        $this->data = [
            'currency' => $currency ?? config("systempay.{$site}.params.currency"),
            'strongAuthentication' => $strongAuth ?? config("systempay.{$site}.params.strongAuthentication"),
            'orderId' => $orderId,
            'customer' => $customer,
            'merchant' => $merchant,
        ];
        $this->token = $this->getToken($site, $this->data);
        $this->key = config("systempay.{$site}.site_id").':'.config("systempay.{$site}.key");

    }

    private function getToken($site, $data)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Basic'.base64_encode(config("systempay.{$site}.site_id").':'.config("systempay.{$site}.password")),
            'Content-Type' => 'application/json'
        ];
        $body = [
            'amount' => $this->amount,
            'currency' => $data['currency'],
        ];

        if(isset($data))
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
