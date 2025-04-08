
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://apigateway.conectagov.estaleiro.serpro.gov.br/api-cpf-light/v2/consulta/cpf',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
"listaCpf" :[
"77689062768"
]
}',
CURLOPT_HTTPHEADER => array(
'x-cpf-usuario: 00000000191',
'Content-Type: application/json',
'Authorization: Bearer eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOnsiaWQiOiJkMmQyMWVlYS0zY2Y4LTRkZDItYTBmMS04OGFmMTA1NTk4M2MiLCJ1c2VySWQiOiJmZTk3MjVhOS1lN2Q3LTQ5MjEtYmRjNi03Y2E5NjhkNjVjNmYiLCJ0eXBlIjoiYXBwbGljYXRpb24iLCJzY29wZXMiOiJhcGktY3BmLWxpZ2h0LXYxIn0sImlhdCI6MTcxMDI0MjY3OSwiZXhwIjoxNzEwMjQ5ODc5LCJhdWQiOiJjb25lY3RhZ292LWF1ZCIsImlzcyI6ImNvbmVjdGFnb3YtaXNzIn0.uxZxq2FPDasTHZ5cAwS44U0wr_M6g0ywLgrZFgwd2JAKM-mgPdxpP8aEUlB7fjpaN9FA55F77t6-WbL0DfSQNSFoO49RIrh5C_NKGEPR0lMA0XpAM9cQ1ktOAZYsly-rnWXWJvc4pGqERAAgKKK-Z1BT_Nc9V4bFFHjLTrWAIseD83XZz64FCsfkEIpuVnMsqyzAhYqfXj7hCScJmIwmtPLMw3bdlHdRK5RHZiMK30Fq6iu9wQfiHsujlpZg13KLxbm7HIclrlJfxOgQ7ktzjAWTzLKYluhXuycFL1TQtfkY03yk30Gu3HMyTDIlQIZi__MU2AmJv82QXchuI7Xqcw'
),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;






$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://apigateway.conectagov.estaleiro.serpro.gov.br/oauth2/jwt-token',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
CURLOPT_HTTPHEADER => array(
'Content-Type: application/x-www-form-urlencoded',
'Authorization: Basic eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOnsiaWQiOiJkMmQyMWVlYS0zY2Y4LTRkZDItYTBmMS04OGFmMTA1NTk4M2MiLCJ1c2VySWQiOiJmZTk3MjVhOS1lN2Q3LTQ5MjEtYmRjNi03Y2E5NjhkNjVjNmYiLCJ0eXBlIjoiYXBwbGljYXRpb24iLCJzY29wZXMiOiJhcGktY3BmLWxpZ2h0LXYxIn0sImlhdCI6MTcxMDI0MjY3OSwiZXhwIjoxNzEwMjQ5ODc5LCJhdWQiOiJjb25lY3RhZ292LWF1ZCIsImlzcyI6ImNvbmVjdGFnb3YtaXNzIn0.uxZxq2FPDasTHZ5cAwS44U0wr_M6g0ywLgrZFgwd2JAKM-mgPdxpP8aEUlB7fjpaN9FA55F77t6-WbL0DfSQNSFoO49RIrh5C_NKGEPR0lMA0XpAM9cQ1ktOAZYsly-rnWXWJvc4pGqERAAgKKK-Z1BT_Nc9V4bFFHjLTrWAIseD83XZz64FCsfkEIpuVnMsqyzAhYqfXj7hCScJmIwmtPLMw3bdlHdRK5RHZiMK30Fq6iu9wQfiHsujlpZg13KLxbm7HIclrlJfxOgQ7ktzjAWTzLKYluhXuycFL1TQtfkY03yk30Gu3HMyTDIlQIZi__MU2AmJv82QXchuI7Xqcw'
),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


