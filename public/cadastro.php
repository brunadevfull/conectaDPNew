<?php
// public/cadastro.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Factories\ControllerFactory;

// Criar o controlador de cadastro
$controller = ControllerFactory::createCadastroController();

// Processar tentativa de cadastro
$controller->cadastrar();

// Se for uma requisição AJAX, não redireciona
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    exit;
}

// Incluir o template de cadastro para acesso direto via navegador
include __DIR__ . '/templates/cadastro.php';