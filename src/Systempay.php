<?php

namespace Frenchykiller\BoilerplateSystempay;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class SystempayController extends Controller

{

    private $_key;
    private $_url;
    private $_params = array();
    private $_nb_products = 0;


    /**
     * Systempay constructor
     * @param       String $site_id unique shop id
     */
    public function __construct($site)
    {
        $this->_key = config("systempay.{$site}.key");
        $this->_url = config("systempay.url");
        //Instanciate parameters array if exist in config file
        $this->_params = config("systempay.{$site}.params");
        //Directly instanciate the transaction parameters
        $this->set_site_id(config("systempay.{$site}.site_id"));
        $this->set_ctx_mode(config("systempay.{$site}.env"));
    }

    private function form()
    {
        $stage = session()->get('stage');
        $participant = session()->get('participant');

        $client = new Client();
        $headers = [
            'Authorization' => 'Basic'.base64_encode(config('systempay.default.site_id').':'.config('systempay.default.password')),
            'Content-Type' => 'application/json'
        ];
        $body = [
            'amount' => $stage->tarif,
            'currency' => config('systempay.params.currency')
        ];

        try{
            $response = $client->request('POST', config('systempay.url').'Charge/CreatePayment', [
                'headers' => $headers,
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            \Log::info($e->getMessage());
        }
        return json_decode($response->getBody()->getContents())->answer->formToken;
    }

    /**
     * Magic method that allows you to use getters and setters on each systempay parameters
     * Remember to not keep the 'vads' prefix in your accessor function name
     * @param       String $method name of the accessor
     * @param       array [optional] $args list of arguments
     * @return      Systempay
     * @throws      InvalidArgumentException
     */
    public function __call($method, $args)
    {
        if (function_exists($method)) {
            return call_user_func_array($method, $args);
        }
        if (preg_match("/get_(.*)/", $method, $matches)) {
            return $this->_params["vads_{$matches[1]}"];
        }
        if (preg_match("/set_(.*)/", $method, $matches)) {
            if (count($args) != 1)
                throw new InvalidArgumentException($method . ' takes one argument.');

            $this->_params["vads_{$matches[1]}"] = $args[0];
            return $this;
        }
    }

    /**
     * Method to do massive assignement of parameters
     * @param           array $params associative array of systempay parameters
     * @return          Systempay
     */
    public function set_params($params)
    {
        $this->_params = array_merge($this->_params, $params);
        return $this;
    }

    /**
     * Get all systempay parameters
     * @return      array associative array of systempay parameters
     */
    public function get_params()
    {
        return $this->_params;
    }

    /**
     * Generate systempay signature and add it to the parameters array
     * @return      Systempay
     */
    public function set_signature()
    {
        ksort($this->_params);
        $s = "";
        foreach ($this->_params as $n => $v)
            $s .= $v . "+";
        $s .= $this->_key;
        $this->_params['signature'] = sha1($s);

        return $this;
    }

    /**
     * Return systempay signature
     * @return      String systempay signature
     */
    public function get_signature()
    {
        return $this->_params['signature'];
    }

    /**
     * Defines the total amount of the order. If you doesn't give the amount in parameter, it will be automaticly calculated
     * by the sum of products you've got in your basket
     * @param       [optional] int $amount, systempay format
     * @return      Systempay
     */
    public function set_amount($amount = 0)
    {
        $this->_params['vads_amount'] = 0;
        if ($amount) {
            $this->_params['vads_amount'] = 100 * $amount;
        } else {//calcul du montant à partir du tableau de paramètre
            array_where($this->_params, function ($value, $key) {
                if (preg_match("/vads_product_amount([0-9]+)/", $key, $match)) {
                    $this->_params['vads_amount'] += $this->_params["vads_product_qty{$match[1]}"] * $value;
                }
            });
        }
        return $this;
    }

    /**
     * Get total amount of the order
     * @param       [optional] bool $decimal if true, you get a decimal otherwise you get standard systempay amount format (int)
     * @return      float
     */
    public function get_amount($decimal = true)
    {
        return $decimal ? $this->_params['vads_amount'] / 100 : $this->_params['vads_amount'];
    }

    /**
     * Return HTML SystempPay form
     * @param       String $button html code of the submit button
     * @return      \Illuminate\Support\HtmlString|string
     */
    public function get_form($button)
    {
        $html_form = '<form method="post" action="' . $this->_url . '" accept-charset="UTF-8">';
        foreach ($this->_params as $key => $value)
            $html_form .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        $html_form .= '<input type="hidden" name="vads_trans_date" value="'.gmdate('YmdHis').'">';
        $html_form .= $button;
        $html_form .= "</form>";
        return $html_form;
    }

    /**
     * Add a product to the order
     * @param       array $product , must have the following keys : 'label,amount,type,ref,qty'
     * @return      Systempay
     */
    public function add_product($product)
    {
        $this->_params = array_merge($this->_params, [
            "vads_product_label{$this->_nb_products}" => $product["label"],
            "vads_product_amount{$this->_nb_products}" => $product["amount"] * 100,
            "vads_product_type{$this->_nb_products}" => $product["type"],
            "vads_product_ref{$this->_nb_products}" => $product["ref"],
            "vads_product_qty{$this->_nb_products}" => $product["qty"]
        ]);
        $this->_params['vads_nb_products'] = $this->_nb_products += 1;
        return $this;
    }

}
