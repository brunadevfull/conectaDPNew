<?php
// public/login.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Factories\ControllerFactory;
use App\Services\AuthService;
use App\Repositories\UsuarioRepository;
use App\Repositories\LoginHistoryRepository;

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
    // Obter credenciais do formulário
    $username = $_POST['username'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Acessar o serviço de autenticação diretamente
    $usuarioRepository = new UsuarioRepository();
    $loginHistoryRepository = new LoginHistoryRepository();
    $authService = new AuthService($usuarioRepository, $loginHistoryRepository);

    // Tentar autenticar
    $result = $authService->authenticate($username, $senha);

    if ($result['success']) {
        // Configurar sessão
        $_SESSION['username'] = $username;
        
        // Adicionar verificação de admin
        $_SESSION['isAdmin'] = isset($result['isAdmin']) ? $result['isAdmin'] : false;

        // Log para depuração
        error_log("Login realizado - Usuário: $username, Admin: " . ($_SESSION['isAdmin'] ? 'Sim' : 'Não'));

        // Redirecionar baseado no perfil
        if ($_SESSION['isAdmin']) {
            header("Location: admin-dashboard.php"); // Crie esta página para admin
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        // Passar mensagem de erro para o template
        $errorMessage = $result['message'];
    }
}

// Incluir o template de login

include __DIR__ . '/../app/Views/pages/login.php';