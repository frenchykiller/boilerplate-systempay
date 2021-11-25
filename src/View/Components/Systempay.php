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
        'fail'
    ];

    public int $amount;
    public string $token;
    public string $key;
    public ?string $success;
    public ?string $fail;

    private ?string $strongAuthentication;
    private ?array $transactionOptions;
    private ?string $orderId;
    private ?string $currency;
    private ?array $customer;
    private ?array $merchant;
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
     * @param int $amount
     * @param mixed $currency
     * @param string $strongAuth
     * @param string $orderId
     * @param array $customer
     * @param array $merchant
     * @param array $transactionOptions
     * @param string $success
     * @param string $fail
     * @param string $site
     *
     * @return void
     */
    public function __construct($amount, $currency = null, $strongAuth = null, $orderId = null, $customer = null, $merchant = null, $transactionOptions = null, $success = null, $fail = null, $site = 'default')
    {
        $this->amount = $amount * 100;
        $this->site = $site;
        $this->currency = $currency ?? config("systempay.{$site}.params.currency");
        $this->strongAuthentication = $strongAuth ?? config("systempay.{$site}.params.strongAuthentication");
        $this->orderId = $orderId;
        $this->customer = $customer;
        $this->merchant = $merchant;
        $this->transactionOptions = $transactionOptions;

        $this->token = $this->getToken($site, [
            'strongAuthentication' => $this->strongAuthentication,
            'currency' => $this->currency,
            'orderId' => $this->orderId,
            'customer' => $this->customer,
            'merchant' => $this->merchant,
            'transactionOptions' => $this->transactionOptions,
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
