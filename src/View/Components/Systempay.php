<?php

namespace Frenchykiller\LaravelSystempay\View\Components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\Component;

class Systempay extends Component
{
    protected array $props = [
        'amount',
        'site',
        'currency',
        'strong-auth',
        'strongAuth',
        'order-id',
        'orderId',
        'customer',
        'merchant',
        'success',
        'fail',
    ];

    public array $request;
    public string $token;
    public string $key;
    public ?string $success;
    public ?string $fail;
    private string $site;

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
     * @param array $request
     * @param string $success
     * @param string $fail
     * @param string $site
     *
     * @return void
     */
    public function __construct($request, $success = null, $fail = null, $site = 'default')
    {
        $this->request = $request;
        $this->site = $site;

        $this->token = $this->getToken($site, [
            'amount' => $request['amount'] * 100,
            'strongAuthentication' => $request['strongAuth'] ?? config("systempay.{$site}.params.strongAuthentication"),
            'currency' => $request['currency'] ?? config("systempay.{$site}.params.currency"),
            'orderId' => $request['orderId'],
            'customer' => $request['customer'],
            'merchant' => $request['merchant'],
            'transactionOptions' => $request['transactionOptions'],
            'metadata' => $request['metadata'],
        ]);
        $this->key = config("systempay.{$site}.site_id").':'.config("systempay.{$site}.key");
        $this->success = $success;
        $this->fail = $fail;
    }

    private function getToken($site, $data)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Basic'.base64_encode(config("systempay.{$site}.site_id").':'.config("systempay.{$site}.password")),
            'Content-Type' => 'application/json'
        ];

        try {
            $response = $client->request('POST', config("systempay.{$site}.url").'Charge/CreatePayment', [
                'headers' => $headers,
                'json' => $data
            ]);
        } catch (GuzzleException $e) {
            \Log::info($e->getMessage());
        }
        return json_decode($response->getBody()->getContents())->answer->formToken;
    }
}
