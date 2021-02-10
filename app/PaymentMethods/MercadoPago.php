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


    public function setupPaymentAndGetRedirectURL($order): array
    {
        $preference = new Preference();
        $products = $order['products'];
        $internalPayer = $order['payer']['data'];
        $shipmentCost = $order['shipment_cost'];
        $itemsArray = array();

        foreach ($products as $product) {
            $item = new Item();
            $item->id = $product['id'];
            $item->title = $product['name'];
            $item->quantity = 1;
            $item->unit_price = $product['price'];
            array_push($itemsArray, $item);
        }

        $preference->items = $itemsArray;

        $preference->shipments = (object)array(
            "cost" => (float)$shipmentCost,
            "mode" => 'not_specified'
        );

        $payer = new Payer();
        $payer->name = $internalPayer['profile']['personalInfo']['name'];
        $payer->surname = $internalPayer['profile']['personalInfo']['lastName'];
        $payer->email = $internalPayer['user']['email'];
        $preference->payer = $payer;

        $preference->back_urls = array(
            "success" => "localhost",
        );

        $preference->auto_return = "approved";

        $preference->save();

        return array(
            'init_point' =>  $preference->init_point,
            'preference_id' => $preference->id
        );
    }
}
