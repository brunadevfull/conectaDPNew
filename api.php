<?php
// api.php
require_once __DIR__ . '/vendor/autoload.php';

// Carregar variáveis de ambiente
use App\Core\EnvLoader;
EnvLoader::load();

use App\Factories\ControllerFactory;
// Resto do seu código...

session_start();

// Usar a factory para criar o controller corretamente
$controller = ControllerFactory::createConsultaController();

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
