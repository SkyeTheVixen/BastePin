<?php
    session_start();
    if(file_exists("../vendor/autoload.php")){
        require '../vendor/autoload.php';
    }else if(file_exists("../../vendor/autoload.php")){
        require '../../vendor/autoload.php';
    }else if(file_exists("vendor/autoload.php")){
        require 'vendor/autoload.php';
    }else if(file_exists("./vendor/autoload.php")){
        require './vendor/autoload.php';
    }
    include("res/php/functions.inc.php");
    $token = GenerateID();
    $_SESSION["paymenttoken"] = $token;

    // This is your test secret API key.
    \Stripe\Stripe::setApiKey('sk_test_51K4lnWDflgYeQa2HKOTtwoswPLs0LfGZcnVktV703ByBz5AIoNAsX7cbCqr8ET4LARibQNiZph0MKAmRy2sGyHC000nTrvr4Oe');

    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'https://skytest.xyz/Bastepin';

    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' => 'price_1K9eIdDflgYeQa2HCnJvpWzk',
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/paymentSuccess.php?token=' . $token,
        'cancel_url' => $YOUR_DOMAIN . '/premium.php?er=cancel',
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url)


?>