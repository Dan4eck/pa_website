<?php

// Initialize test payment parameters
$merchant_login = 'pa_website';
$merchant_test_pass1 = 'iSzPmfF77vaNY277Bbbo'; // Using test password instead of production
$out_sum = '20';
$inv_id = '0';
$description = 'тестоплата';
$is_test = 1; // Enable test mode

// Create signature string for test mode
$signature_string = "{$merchant_login}:{$out_sum}:{$inv_id}:{$merchant_test_pass1}";

// Generate signature using MD5
$signature = md5($signature_string);

// Generate test payment URL
$payment_url = "https://auth.robokassa.ru/Merchant/Index.aspx?" . 
    "MerchantLogin=" . urlencode($merchant_login) . 
    "&OutSum=" . urlencode($out_sum) . 
    "&InvoiceID=" . urlencode($inv_id) . 
    "&Description=" . urlencode($description) . 
    "&SignatureValue=" . $signature . 
    "&IsTest=" . $is_test; // Added IsTest parameter

// Output the payment URL
echo $payment_url;
?>