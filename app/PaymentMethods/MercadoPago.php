<?php

namespace App\PaymentMethods;

use Illuminate\Support\Facades\Date;
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

        $preference->expires = true;
        $preference->expiration_date_from = Date::now();
        $preference->expiration_date_to = Date::tomorrow();

        $preference->auto_return = "approved";

        $preference->save();

        return array(
            'init_point' =>  $preference->init_point,
            'preference_id' => $preference->id
        );
    }

    static function updateExternalReference($preferenceId, $purchase){
        $ch = curl_init('https://api.mercadopago.com/checkout/preferences/'.$preferenceId);
        $authorization = "Authorization: Bearer " . config("payment-methods.mercadopago.token");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            $authorization
        ));

        $mensaje = json_encode(array('external_reference' => $purchase->id));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $mensaje);
        $respuesta['mensaje_recibido'] = curl_exec($ch);
        $respuesta['httpcode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $respuesta['httpcode'];
    }

    static function getPayment($payment){

        $ch = curl_init('https://api.mercadopago.com/v1/payments/search?external_reference='.$payment->purchase_id);
        $authorization = "Authorization: Bearer " . config("payment-methods.mercadopago.token");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            $authorization
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        $respuesta = json_decode($respuesta);

        return empty($respuesta->results) ? null : $respuesta->results[0];
    }
}
