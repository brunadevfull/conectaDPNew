<?php



require_once __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/app/controllers/ConsultaController.php'; // Adicionando o caminho para o Controller
use App\Models\ConsultaModel;
use App\Controllers\ConsultaController; // Importando o Controller

$model = new ConsultaModel();

$controller = new ConsultaController(); // Instanciando o Controller

// Aqui você pode definir um CNPJ para testar
$cnpj = '90026000000153';

// URL, clientId e clientSecret específicos para CNPJ
$tokenUrl = 'https://h-apigateway.conectagov.estaleiro.serpro.gov.br/oauth2/jwt-token';
$clientId = 'c825bdf9-abb0-4c98-8616-6a57b0946d69';
$clientSecret = 'eb167127-aaaa-4f13-84a9-b80fac1ab77d';

// Obtém o token OAuth2 específico para CNPJ
$opcao = 'CNPJ'; // ou 'CPF', dependendo da escolha do usuário
$oauthToken = $model->obterTokenOAuth2($tokenUrl, $clientId, $clientSecret, $opcao);
echo "Token OAuth2: " . $oauthToken . "\n";


if ($oauthToken) {
 
    $consultaUrl = 'https://h-apigateway.conectagov.estaleiro.serpro.gov.br/api-cnpj-basica/v2/basica/' . $cnpj;

  
    $cnpjData = $model->realizarConsultaCNPJ($consultaUrl, $oauthToken);

 
    var_dump($cnpjData);
} else {
    echo "Erro ao obter o token OAuth2 para CNPJ.";
}

?>
