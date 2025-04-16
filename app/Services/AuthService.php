<?php
// app/Services/AuthService.php (parcial)
namespace App\Services;

use App\Models\Usuario;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\Interfaces\LoginHistoryRepositoryInterface;

class AuthService
{
    private $usuarioRepository;
    private $loginHistoryRepository;
    private $maxLoginAttempts = 3;

    public function __construct(
        UsuarioRepositoryInterface $usuarioRepository,
        LoginHistoryRepositoryInterface $loginHistoryRepository
    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->loginHistoryRepository = $loginHistoryRepository;
    }

    public function authenticate($username, $password)
    {
        // Log de tentativa de login
        error_log("Tentativa de login - Username: $username");

        // Verificar se o usuário existe
        $usuario = $this->usuarioRepository->findByUsername($username);
        
        if (!$usuario) {
            // Log de usuário não encontrado
            error_log("Usuário não encontrado: $username");
            $this->loginHistoryRepository->registerFailedAttempt($username);
            return ['success' => false, 'message' => 'Usuário não encontrado.'];
        }

        // Log de informações do usuário
        error_log("Usuário encontrado - Perfil: " . $usuario->getPerfil());

        // Verificar se o usuário está bloqueado
        if ($usuario->isBloqueado()) {
            // Verificar se o período de bloqueio já acabou
            $dataBloqueio = new \DateTimeImmutable($usuario->getDataBloqueio());
            $agora = new \DateTimeImmutable();
            
            if ($agora > $dataBloqueio->modify('+24 hours')) {
                $this->usuarioRepository->unblockUser($usuario);
            } else {
                return ['success' => false, 'message' => 'Sua conta está bloqueada.'];
            }
        }

        // Verificar credenciais
        if (password_verify($password, $usuario->getSenha())) {
            // Login bem-sucedido
            $this->loginHistoryRepository->registerSuccessfulLogin($username);
            $this->loginHistoryRepository->resetFailedAttempts($username);
            
            // Atualizar último login
            $usuario->setLastLogin(date('Y-m-d H:i:s'));
            $this->usuarioRepository->save($usuario);

            // Verificação explícita do perfil de admin
            $isAdmin = strtolower(trim($usuario->getPerfil())) === 'admin';
            
            // Log de verificação de admin
            error_log("Verificação de Admin - Resultado: " . ($isAdmin ? 'Sim' : 'Não'));

            return [
                'success' => true, 
                'user' => $usuario,
                'isAdmin' => $isAdmin,
                'message' => $isAdmin ? 'Login de administrador bem-sucedido' : 'Login bem-sucedido'
            ];
        } else {
            // Login mal-sucedido
            $this->loginHistoryRepository->registerFailedAttempt($username);
            
            // Verificar tentativas restantes
            $attempts = $this->loginHistoryRepository->getFailedAttempts($username);
            $remainingAttempts = $this->maxLoginAttempts - $attempts;
            
            if ($remainingAttempts <= 0) {
                $this->usuarioRepository->blockUser($usuario);
                return ['success' => false, 'message' => 'Sua conta foi bloqueada.'];
            }
            
            return [
                'success' => false,
                'message' => "Credenciais inválidas. Tentativas restantes: $remainingAttempts"
            ];
        }
    }
}