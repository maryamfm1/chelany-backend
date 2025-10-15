<?php

namespace App\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalService
{
    protected $apiContext;

    public function __construct()
    {
        // 👇 Test: check config is loaded
    \Log::info("PayPal client ID: " . config('paypal.client_id'));
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );

        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function getApiContext()
    {
        return $this->apiContext;
    }
}
