<?php

// Configurações da API
$client_id = "22ff59c1-d7ac-4bc7-acb7-0d3dce8de04f";
$client_secret = "S4890095b-75a0-47cd-81e2-df3dcf93e03b";
$token_url = "https://apigateway.conectagov.estaleiro.serpro.gov.br/oauth/token";
$api_url = "https://apigateway.conectagov.estaleiro.serpro.gov.br/api-relacao-trabalhista/v1/relacoes-trabalhistas?cpf=13899289773";

// Função para obter um novo token OAuth2
function obterToken($client_id, $client_secret, $token_url) {
    $data = [
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "grant_type" => "client_credentials",
        "scope" => "api-relacao-trabalhista-v1"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        die("Erro ao obter o token.");
    }

    $json = json_decode($response, true);
    
    if (isset($json["access_token"])) {
        return $json["access_token"];
    } else {
        die("Erro ao autenticar: " . $response);
    }
}

// Obtém o token da API
$token = obterToken($client_id, $client_secret, $token_url);
echo "Token obtido: " . $token . "\n\n";

// Função para consultar o CNIS usando o token obtido
function consultarCNIS($api_url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token,
        "Accept: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        die("Erro ao consultar API.");
    }

    return json_decode($response, true);
}


// Faz a requisição à API com o novo token
$resultado = consultarCNIS($api_url, $token);

// Exibe o resultado formatado
echo "Resposta da API:\n";
print_r($resultado);
?>
