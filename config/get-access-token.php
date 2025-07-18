<?php
require 'paypal.php';

function getAccessToken() {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, PAYPAL_BASE_URL . "/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRET);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    $headers = [
        "Content-Type: application/x-www-form-urlencoded"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $res = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        return null;
    }
    curl_close($ch);

    $data = json_decode($res, true);
    return $data['access_token'] ?? null;
}