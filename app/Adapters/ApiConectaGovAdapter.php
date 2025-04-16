<?php

namespace App\Adapters;

class ApiConectaGovAdapter
{
    private $tokenUrl;
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $serviceType;

    public function __construct($serviceType)
    {
        $this->serviceType = $serviceType;
        $this->tokenUrl = getenv("API_{$serviceType}_URL");
        $this->clientId = getenv("API_{$serviceType}_CLIENT_ID");
        $this->clientSecret = getenv("API_{$serviceType}_CLIENT_SECRET");
        
        // Debug para verificar se as variáveis estão sendo lidas corretamente
        error_log("TokenURL: " . $this->tokenUrl);
        error_log("ClientID: " . $this->clientId);
        error_log("ClientSecret: " . substr($this->clientSecret, 0, 5) . "...");
    }

    

    public function getToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        error_log("Tentando obter token para: " . $this->serviceType);
        error_log("URL: " . $this->tokenUrl);
        error_log("Client ID: " . $this->clientId);

        $authorization = base64_encode("{$this->clientId}:{$this->clientSecret}");
        $headers = [
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic $authorization"
        ];

        $data = http_build_query(["grant_type" => "client_credentials"]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception("Erro ao obter token OAuth2: " . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception("Falha ao obter token. Código HTTP: $httpCode. Resposta: $response");
        }

        $responseData = json_decode($response, true);
        $this->accessToken = $responseData['access_token'];
        
        return $this->accessToken;
    }

    public function consultaCpf($listaCpf)
    {
        $token = $this->getToken();
        $url = 'https://apigateway.conectagov.estaleiro.serpro.gov.br/api-cpf-light/v2/consulta/cpf';
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode(['listaCpf' => $listaCpf]),
            CURLOPT_HTTPHEADER => [
                'x-cpf-usuario: 00000000191',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    public function consultaCnpj($cnpj)
    {
        $token = $this->getToken();
        $url = "https://apigateway.conectagov.estaleiro.serpro.gov.br/api-cnpj-basica/v2/basica/{$cnpj}";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'x-cpf-usuario: 00000000191'
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    public function consultaCnis($cpf)
    {
        $token = $this->getToken();
        $url = "https://apigateway.conectagov.estaleiro.serpro.gov.br/api-relacao-trabalhista/v1/relacoes-trabalhistas?cpf={$cpf}";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'x-cpf-usuario: 00000000191'
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
}