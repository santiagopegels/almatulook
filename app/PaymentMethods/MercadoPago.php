<?php

namespace App\PaymentMethods;

use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPago
{
    public function __construct()
    {
        SDK::setAccessToken(
            config("payment-methods.mercadopago.token")
        );
        SDK::setPublicKey(
            config("payment-methods.mercadopago.public_key")
        );
    }


    public function setupPaymentAndGetRedirectURL(): string
    {
        $preference = new Preference();

        $item = new Item();
        $item->title = 'Mi producto';
        $item->quantity = 1;
        $item->unit_price = 75.56;
        $preference->items = array($item);
        $payer = new Payer();
        $payer->email = 'test_user_35686199@testuser.com';
        $preference->payer = $payer;

        $preference->back_urls = array(
            "success" => "localhost",
        );

        $preference->auto_return = "approved";

        $preference->save();

        return $preference->init_point;
    }
}
