<?php
// app/Controllers/api.php - Versão corrigida
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Factories\ControllerFactory;

session_start();

// Usar a factory para criar o controller
$controller = ControllerFactory::createConsultaController();

header('Content-Type: application/json');

// Checagem básica do método HTTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'autenticar':
            $controller->autenticar();
            break;
        case 'consultar':
            $controller->consultar();
            break;
        default:
            echo json_encode(['error' => 'Ação não especificada ou inválida']);
            break;
    }
} else {
    echo json_encode(['error' => 'Método HTTP não suportado']);
}