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
        // Verificar se o usuário existe
        $usuario = $this->usuarioRepository->findByUsername($username);

        if (!$usuario) {
            $this->loginHistoryRepository->registerFailedAttempt($username);
            return ['success' => false, 'message' => 'Usuário não encontrado.'];
        }

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
            
            return ['success' => true, 'user' => $usuario];
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