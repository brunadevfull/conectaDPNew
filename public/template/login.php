<?php
// public/login.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Factories\ControllerFactory;

// Criar o controlador de consulta (que contém o método de autenticação)
$controller = ControllerFactory::createConsultaController();

// Verificar se já existe uma sessão ativa
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Processar tentativa de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->autenticar();
}

// Incluir o template de login
include __DIR__ . '/templates/login.php';