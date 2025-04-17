<?php

// Função para codificar credenciais em Base64
function obterCredenciaisBase64($clientId, $clientSecret)
{
    return base64_encode("$clientId:$clientSecret");
}

// Função para obter o token OAuth2
function obterTokenOAuth2($tokenUrl, $clientId, $clientSecret)
{
    // Codifica as credenciais em Base64
    $authorization = obterCredenciaisBase64($clientId, $clientSecret);

    // Define os headers com o Authorization: Basic
    $headers = [
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Basic $authorization"
    ];

    $data = http_build_query([
        "grant_type" => "client_credentials"
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die("Erro ao obter token OAuth2: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        die("Falha ao obter token. Código HTTP: $httpCode. Resposta: $response");
    }

    $responseData = json_decode($response, true);
    return $responseData['access_token'];
}


// Função para realizar a consulta de relação trabalhista
function consultarRelacaoTrabalhista($consultaUrl, $cpf, $token, $cpfUsuario, $dataNascimento=null)
{
    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json",
        "x-cpf-usuario: $cpfUsuario" // Adiciona o CPF do usuário autenticado
    ];

    // Monta a URL com os parâmetros
    $urlComParametros = $consultaUrl . "?cpf=" . $cpf;
    if (!empty($dataNascimento)) {
        $urlComParametros .= "&dataNascimento=" . urlencode($dataNascimento);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlComParametros);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die("Erro ao consultar relação trabalhista: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        die("Falha na consulta. Código HTTP: $httpCode. Resposta: $response");
    }

    return json_decode($response, true);
}

// Configurações
$tokenUrl = 'https://apigateway.conectagov.estaleiro.serpro.gov.br/oauth2/jwt-token';
$clientId = '22ff59c1-d7ac-4bc7-acb7-0d3dce8de04f'; // Substitua pelo seu Client ID
$clientSecret = '4890095b-75a0-47cd-81e2-df3dcf93e03b'; // Substitua pelo seu Client Secret
$consultaUrl = 'https://apigateway.conectagov.estaleiro.serpro.gov.br/api-relacao-trabalhista/v1/relacoes-trabalhistas';
$cpf = '85959685787'; // Substitua por um CPF válido
$dataNascimento = null;// Substitua por uma data válida no formato YYYY-MM-DD
$cpfUsuario = '13899289773'; // Certifique-se de substituir por um CPF válido do usuário autenticado no sistema
echo "Enviando CPF: $cpf\n";
echo "Enviando Data de Nascimento: $dataNascimento\n";

// Obter token OAuth2
echo "Obtendo token OAuth2...\n";
$token = obterTokenOAuth2($tokenUrl, $clientId, $clientSecret);
echo "Token obtido com sucesso: $token\n\n";

// Realizar consulta de relação trabalhista
echo "Consultando relação trabalhista...\n";
$resultado = consultarRelacaoTrabalhista($consultaUrl, $cpf,  $token, $cpfUsuario, $dataNascimento);

// Exibir resultado
echo "Resultado da consulta:\n";
echo json_encode($resultado, JSON_PRETTY_PRINT);


?>
