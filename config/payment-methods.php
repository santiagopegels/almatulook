<?php

return [

    'enabled' => [
        'mercadopago',
    ],

    'mercadopago' => [
        'display' => 'MercadoPago',
        'token' => env('MP_ACCESS_TOKEN'),
        'public_key' => env('MP_PUBLIC_KEY'),
    ],

];
