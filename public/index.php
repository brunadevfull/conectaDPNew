<?php
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Factories\ControllerFactory;

session_start();

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

// Carregar a página principal
include 'Views/header.php';
include 'Views/consulta.php';
include 'Views/footer.php';