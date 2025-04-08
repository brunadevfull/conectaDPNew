<?php

require __DIR__ . '/vendor/autoload.php'; // Certifique-se de ajustar o caminho corretamente
use PhpOffice\PhpSpreadsheet\IOFactory;

function obterTokenOAuth2($tokenUrl, $clientId, $clientSecret) {
    $authorization = base64_encode("$clientId:$clientSecret");
    $headers = [
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Basic $authorization"
    ];

    $data = http_build_query(["grant_type" => "client_credentials"]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception("Erro ao obter token OAuth2: " . curl_error($ch));
    }

    curl_close($ch);
    $responseData = json_decode($response, true);

    return $responseData['access_token'] ?? null;
}

function lerCPFsDoExcel($filePath) {
    $cpfArray = [];

    if (!file_exists($filePath)) {
        throw new Exception('Arquivo não encontrado: ' . $filePath);
    }

    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();

    foreach ($worksheet->getRowIterator() as $row) {
        $cellValue = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
        $cpf = preg_replace('/\D/', '', $cellValue);

        if (strlen($cpf) === 11) { // Apenas CPFs válidos (11 dígitos)
            $cpfArray[] = $cpf;
        }
    }

    return $cpfArray;
}

function enviarLotesParaAPI($cpfs, $apiUrl, $oauthToken) {
    $lotes = array_chunk($cpfs, 5); // Divide em lotes de 50 CPFs
    $resultados = [];
    $logFile = __DIR__ . "/api_log.txt"; // Arquivo de log para acompanhar a execução

    file_put_contents($logFile, "Iniciando envio dos lotes...\n", FILE_APPEND);

    foreach ($lotes as $index => $lote) {
        echo "Enviando lote " . ($index + 1) . " de " . count($lotes) . "...\n";
        file_put_contents($logFile, "Enviando lote " . ($index + 1) . "...\n", FILE_APPEND);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $oauthToken",
            "Content-Type: application/json",
            "x-cpf-usuario: 00000000191"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['listaCpf' => $lote]));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseData = json_decode($response, true);
        
        if ($httpCode !== 200) {
            echo "Erro na API: HTTP $httpCode - $response\n";
            file_put_contents($logFile, "Erro no lote " . ($index + 1) . ": HTTP $httpCode - $response\n", FILE_APPEND);
            continue;
        }

        if (isset($responseData['error'])) {
            echo "Erro no lote " . ($index + 1) . ": " . $responseData['error'] . "\n";
            file_put_contents($logFile, "Erro na resposta: " . $responseData['error'] . "\n", FILE_APPEND);
            continue;
        }

        $resultados = array_merge($resultados, $responseData);

        // Salvar lote a cada requisição bem-sucedida
        file_put_contents(__DIR__ . "/resultado.json", json_encode($resultados, JSON_PRETTY_PRINT));
    }

    return $resultados;
}

// ===== CONFIGURAÇÕES =====
$tokenUrl = 'https://apigateway.conectagov.estaleiro.serpro.gov.br/oauth2/jwt-token';
$clientId = 'd2d21eea-3cf8-4dd2-a0f1-88af1055983c';
        $clientSecret = '40b8cb59-efd5-49a2-8d4e-726067fedeba';
$apiUrl = 'https://apigateway.conectagov.estaleiro.serpro.gov.br/api-cpf-light/v2/consulta/cpf';
$arquivoExcel = __DIR__ . "/cpfs.xlsx"; // Caminho do arquivo

try {
    echo "Lendo CPFs do arquivo...\n";
    $cpfs = lerCPFsDoExcel($arquivoExcel);
    
    if (empty($cpfs)) {
        throw new Exception("Nenhum CPF válido encontrado no arquivo.");
    }

    echo "Obtendo token OAuth2...\n";
    $token = obterTokenOAuth2($tokenUrl, $clientId, $clientSecret);

    if (!$token) {
        throw new Exception("Falha ao obter token OAuth2.");
    }

    echo "Enviando CPFs para a API...\n";
    $resultados = enviarLotesParaAPI($cpfs, $apiUrl, $token);

    if (!empty($resultados)) {
        echo "Consulta concluída! Resultados salvos em 'resultado.json'.\n";
    } else {
        echo "Nenhum resultado retornado pela API.\n";
    }
} catch (Exception $e) {
    file_put_contents(__DIR__ . "/api_log.txt", "Erro: " . $e->getMessage() . "\n", FILE_APPEND);
    echo "Erro: " . $e->getMessage() . "\n";
}
