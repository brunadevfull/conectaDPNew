<?php

$clientId = 'c825bdf9-abb0-4c98-8616-6a57b0946d69';
$clientSecret = 'eb167127-aaaa-4f13-84a9-b80fac1ab77d';

$credentials = "$clientId:$clientSecret";
$base64Credentials = base64_encode($credentials);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://h-apigateway.conectagov.estaleiro.serpro.gov.br/oauth2/jwt-token', // Endpoint para obter o token
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST', 
    CURLOPT_POSTFIELDS => 'grant_type=client_credentials',  
    CURLOPT_HTTPHEADER => array(
        'x-cpf-usuario: 00000000191',
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic ' . $base64Credentials
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
