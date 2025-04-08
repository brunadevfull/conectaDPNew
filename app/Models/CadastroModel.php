<?php
namespace App\Models;

class CadastroModel {
    private $conexao;

    public function __construct() {
        $this->conexao = new \PDO('pgsql:host=10.1.129.38;dbname=conectapapem', 'conectapapem_rw', 'C0n3ct@P@pem!RW2025');
        $this->conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function usuarioExiste($username) {
        $query = "SELECT COUNT(*) FROM usuario WHERE username = :username";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function validarSenha($senha) {
        return strlen($senha) >= 12 &&
               preg_match('/[A-Z]/', $senha) &&
               preg_match('/[a-z]/', $senha) &&
               preg_match('/\d/', $senha) &&
               preg_match('/[^a-zA-Z\d]/', $senha);
    }

    private function limparNIP($nip) {
        $nipLimpo = preg_replace('/\D/', '', $nip);
        return (strlen($nipLimpo) === 8) ? $nipLimpo : false;
    }

    public function cadastrarUsuario($username, $senha, $perfil, $permissoes = []) {
        try {
            $nipLimpo = $this->limparNIP($username);
            if (!$nipLimpo) return "NIP deve conter exatamente 8 dígitos.";
            if ($this->usuarioExiste($nipLimpo)) return "Usuário já existe.";
            if (!$this->validarSenha($senha)) return "Senha não atende aos critérios.";
    
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
            // Inserir usuário
            $query = "INSERT INTO usuario (username, senha, perfil) VALUES (:username, :senha, :perfil)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':username', $nipLimpo);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':perfil', $perfil);
            $stmt->execute();
    
            // Buscar o ID do usuário recém-criado
            $queryId = "SELECT id FROM usuario WHERE username = :username LIMIT 1";
            $stmtId = $this->conexao->prepare($queryId);
            $stmtId->bindParam(':username', $nipLimpo);
            $stmtId->execute();
            $userId = $stmtId->fetchColumn();
    
            // Inserir permissões se for usuário comum
            if ($perfil === 'usuario' && $userId && !empty($permissoes)) {
                $queryPerm = "INSERT INTO permissoes_api (id_usuario, recurso, permitido) 
                              VALUES (:usuario_id, :recurso, true)";
                $stmtPerm = $this->conexao->prepare($queryPerm);
            
                foreach ($permissoes as $recurso) {
                    $stmtPerm->execute([
                        ':usuario_id' => $userId,
                        ':recurso' => strtolower($recurso)
                    ]);
                }
            }
            
            
    
            return "Usuário cadastrado com sucesso.";
        } catch (\PDOException $e) {
            return "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    }
    
}
