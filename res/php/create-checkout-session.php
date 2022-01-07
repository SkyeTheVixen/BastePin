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

    include("_connect.php");
    include("functions.inc.php");
    include("_authcheck.php");


    //Generate a payment token
    $token = GenerateID();
    $_SESSION["paymenttoken"] = $token;



    // This is your test secret API key.
    \Stripe\Stripe::setApiKey('sk_test_51K4lnWDflgYeQa2HKOTtwoswPLs0LfGZcnVktV703ByBz5AIoNAsX7cbCqr8ET4LARibQNiZph0MKAmRy2sGyHC000nTrvr4Oe');

    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'https://bastepin.vixendev.com';

    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' => 'price_1KEYvxDflgYeQa2HcZOdTyEi',
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/paymentSuccess.php?token=' . $token,
        'cancel_url' => $YOUR_DOMAIN . '/premium?er=cancel',
    ]);

    //redirect to checkout page
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url)


?>