<?php
// public/login.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Factories\ControllerFactory;

// Configurações de erro para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sessão uma única vez
session_start();

// Verificar se já existe uma sessão ativa
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Criar o controlador
$controller = ControllerFactory::createConsultaController();

// Processar tentativa de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->autenticar();
}

// Incluir o template de login
include __DIR__ . '/templates/login.php';