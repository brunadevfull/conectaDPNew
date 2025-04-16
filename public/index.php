<?php
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

// Carregar variáveis de ambiente com nossa própria classe
use App\Core\EnvLoader;
EnvLoader::load();

use App\Factories\ControllerFactory;

session_start();
// Resto do seu código...

// Verificar se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar inatividade
$tempoLimite = 10000;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempoLimite)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=true");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();


// Obter informações do usuário
$controller = ControllerFactory::createConsultaController();
$nomeUsuario = $_SESSION['username'];

// Configuração da página
$pageTitle = 'Consulta de Dados';
$includeJqWidgets = true; // Define se deve incluir JQWidgets

// Verificar existência dos arquivos antes de incluir
$headerPath = realpath(__DIR__ . '/../app/Views/layouts/header.php');
$consultaPath = realpath(__DIR__ . '/../app/Views/pages/consulta.php');
$footerPath = realpath(__DIR__ . '/../app/Views/layouts/footer.php');

if ($headerPath && $consultaPath) {
    include $headerPath;
    include $consultaPath;
    
    // Incluir footer apenas se existir
    if ($footerPath) {
        include $footerPath;
    }
} else {
    echo "Erro: Não foi possível encontrar um ou mais arquivos de view.";
    if (!$headerPath) echo "\nHeader não encontrado em: " . __DIR__ . '/../app/Views/layouts/header.php';
    if (!$consultaPath) echo "\nConsulta não encontrado em: " . __DIR__ . '/../app/Views/pages/consulta.php';
    if ($footerPath === false) echo "\nFooter não encontrado em: " . __DIR__ . '/../app/Views/layouts/footer.php';
}