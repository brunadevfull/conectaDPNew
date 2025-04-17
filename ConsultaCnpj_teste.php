<?php

$curl = curl_init();


$cnpj = '33683111000107';

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://h-apigateway.conectagov.estaleiro.serpro.gov.br/api-cnpj-basica/v2/basica/'.$cnpj, // Adicionando o CNPJ à URL
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'x-cpf-usuario: 00000000191',
        'Content-Type: application/json',
        'Authorization: Bearer eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOnsiaWQiOiJjODI1YmRmOS1hYmIwLTRjOTgtODYxNi02YTU3YjA5NDZkNjkiLCJ1c2VySWQiOiI0M2YwY2Y3OC1kN2RiLTQ4MWYtOTRjNi0zZmNmNDhmMzAyNGIiLCJ0eXBlIjoiYXBwbGljYXRpb24iLCJzY29wZXMiOiJhcGktY25wai1iYXNpY2EifSwiaWF0IjoxNzE0NDg0MjkyLCJleHAiOjE3MTQ1Mjc0OTIsImF1ZCI6ImNvbmVjdGFnb3YtYXVkIiwiaXNzIjoiY29uZWN0YWdvdi1pc3MifQ.SwnJNnQy42vPi7xuNTFfXddcTgRow9OKmbObsqC8o5kKwGK1zCrwe0qm9FdithuqNZrx__0qijiEO3tRwHt63O0cvwsqcuY-TmRv668lzEwGyrMAxWROvYgDjRshFVDiT1QMCEQH5m4aY71Lrqjz61x9GKdkdLaetIfG1YawALLYtTPRhmK7rVnCbjTPIRH3yvkBIxLkjMXoaM-_-aNjVFKqldhnfwq75PekGZwfDsSw2ng4kbg6fP8XRZKJ2FVbk361S8nY5rHwxE02WCnVrW7trN6bRUxwqoJbgmY91APqy0DlAO5xHKFDvAJIwDiGPdSohlIE4Ocny2lSOsFtZA'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

