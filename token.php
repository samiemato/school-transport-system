<?php
$consumerKey = "ZG2i6xc84iWBiMbNDcR1nwJs5L5oA8jhoTdh8a3m6yuiFWeO";
$consumerSecret = "bwNB1Hy5JOtCBDGAAnYCc6Np6jRaivkauyUYqGptmBX6tZ5RgpxZhsfV9SV5vcbR";

$credentials = base64_encode($consumerKey . ":" . $consumerSecret);

$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);

if ($response === false) {
    die('Curl error: ' . curl_error($curl));
}
curl_close($curl);

$result = json_decode($response, true);

echo "<pre>";
print_r($result);
echo "</pre>";
