<?php
require_once __DIR__ . '/vendor/autoload.php'; // Ajuste o caminho conforme necessário

require __DIR__ . '/app/Controllers/ConsultaController.php';
use App\Controllers\ConsultaController;


session_start();

$controller = new ConsultaController();

header('Content-Type: application/json');


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
?>
