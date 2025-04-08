<?php

function obterTokenOAuth2($tokenUrl, $clientId, $clientSecret)
{
    // Codifica o clientId e clientSecret em Base64
    $authorization = base64_encode($clientId . ':' . $clientSecret);

    // Configuração dos headers
    $headers = [
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Basic " . $authorization // Inclui o cabeçalho Basic Auth
    ];

    // Parâmetros para o corpo da solicitação
    $data = http_build_query([
        "grant_type" => "client_credentials"
    ]);

    // Inicializa o cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Executa a solicitação
    $response = curl_exec($ch);

    // Verifica se houve erro na solicitação
    if (curl_errno($ch)) {
        die("Erro ao obter token OAuth2: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Verifica o código de resposta HTTP
    if ($httpCode !== 200) {
        die("Falha ao obter token. Código HTTP: $httpCode. Resposta: $response");
    }

    // Decodifica e retorna o token
    $responseData = json_decode($response, true);
    return $responseData['access_token'];
}

// Configurações
$tokenUrl = 'https://apigateway.conectagov.estaleiro.serpro.gov.br/oauth2/jwt-token';
$clientId = 'e7455cc9-05b5-4acd-bc4b-18f39a4e5e45'; // Substitua pelo Client ID fornecido
$clientSecret = '1df9eefe-f3de-492a-90aa-fe31825cd2c9'; // Substitua pelo Client Secret fornecido

// Obter o token OAuth2
echo "Obtendo token OAuth2...\n";
$token = obterTokenOAuth2($tokenUrl, $clientId, $clientSecret);

// Exibir o token obtido
echo "Token obtido com sucesso:\n";
echo $token . "\n";

?>
