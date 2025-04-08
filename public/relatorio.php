<?php
// public/relatorio.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Factories\ControllerFactory;

session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar se o usuário tem permissão de administrador
if ($_SESSION['perfil'] !== 'admin') {
    header("Location: restrito.php");
    exit();
}

// Criar o controlador e gerar o relatório
$controller = ControllerFactory::createRelatorioController();
$controller->gerarRelatorio();