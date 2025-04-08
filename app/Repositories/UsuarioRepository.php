<?php
// app/Repositories/UsuarioRepository.php
namespace App\Repositories;

use App\Core\Database;
use App\Models\Usuario;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($id): ?Usuario
    {
        $query = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function findByUsername($username): ?Usuario
{
    try {
        // Especificar o esquema pode ajudar
        $query = "SELECT * FROM public.usuario WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    } catch (\PDOException $e) {
        error_log("Erro ao buscar usuário: " . $e->getMessage());
        return null;
    }
}

    public function save(Usuario $usuario): bool
    {
        try {
            if ($usuario->getId()) {
                // Update
                $query = "UPDATE usuario SET 
                          username = :username,
                          senha = :senha,
                          perfil = :perfil,
                          status_bloqueio = :status_bloqueio,
                          data_bloqueio = :data_bloqueio,
                          last_login = :last_login
                          WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $usuario->getId());
            } else {
                // Insert
                $query = "INSERT INTO usuario (username, senha, perfil, status_bloqueio) 
                          VALUES (:username, :senha, :perfil, :status_bloqueio)";
                $stmt = $this->db->prepare($query);
            }

            $data = $usuario->toArray();
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':senha', $data['senha']);
            $stmt->bindParam(':perfil', $data['perfil']);
            $stmt->bindParam(':status_bloqueio', $data['status_bloqueio']);
            
            if ($usuario->getId()) {
                $stmt->bindParam(':data_bloqueio', $data['data_bloqueio']);
                $stmt->bindParam(':last_login', $data['last_login']);
            }

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Erro ao salvar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function exists($username): bool
    {
        $query = "SELECT COUNT(*) FROM usuario WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function blockUser(Usuario $usuario): bool
    {
        $usuario->setStatusBloqueio('bloqueado');
        $usuario->setDataBloqueio(date('Y-m-d H:i:s'));
        return $this->save($usuario);
    }

    public function unblockUser(Usuario $usuario): bool
    {
        $usuario->setStatusBloqueio('ativo');
        $usuario->setDataBloqueio(null);
        return $this->save($usuario);
    }
}