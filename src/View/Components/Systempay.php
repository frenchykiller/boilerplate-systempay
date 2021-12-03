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
        'has-button',
        'hasButton',
        'customer',
        'merchant',
        'success',
        'fail',
    ];

    public array $request;
    public bool $hasButton;
    public string $token;
    public string $key;
    public ?string $successPost;
    public ?string $successGet;
    public ?string $failPost;
    public ?string $failGet;
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
     * @param array  $request
     * @param bool   $hasButton
     * @param string $successPost
     * @param string $successGet
     * @param string $failPost
     * @param string $failGet
     * @param string $site
     *
     * @return void
     */
    public function __construct($request, $hasButton = true, $successPost = null, $successGet = null, $failPost = null, $failGet = null, $site = 'default')
    {
        $this->request = $request;
        $this->hasButton = $hasButton;
        $this->site = $site;

        $this->token = $this->getToken($site, [
            'amount'                => $request['amount'] * 100,
            'strongAuthentication'  => $request['strongAuth'] ?? config("systempay.{$site}.params.strongAuthentication"),
            'currency'              => $request['currency'] ?? config("systempay.{$site}.params.currency"),
            'orderId'               => $request['orderId'] ?? null,
            'customer'              => $request['customer'] ?? null,
            'merchant'              => $request['merchant'] ?? null,
            'transactionOptions'    => $request['transactionOptions'] ?? null,
            'metadata'              => $request['metadata'] ?? null,
        ]);
        $this->key = config("systempay.{$site}.site_id").':'.config("systempay.{$site}.key");
        $this->successPost = $successPost;
        $this->successGet = $successGet;
        $this->failPost = $failPost;
        $this->failGet = $failGet;
    }

    protected function getToken($site, $data)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Basic'.base64_encode(config("systempay.{$site}.site_id").':'.config("systempay.{$site}.password")),
            'Content-Type'  => 'application/json',
        ];

        try {
            $response = $client->request('POST', config("systempay.{$site}.url").'Charge/CreatePayment', [
                'headers'   => $headers,
                'json'      => $data,
            ]);
        } catch (GuzzleException $e) {
            \Log::info($e->getMessage());
        }

        return json_decode($response->getBody()->getContents())->answer->formToken;
    }
}
