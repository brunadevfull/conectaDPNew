<?php
// app/Repositories/LoginHistoryRepository.php
namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Interfaces\LoginHistoryRepositoryInterface;

class LoginHistoryRepository implements LoginHistoryRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function registerSuccessfulLogin($username)
    {
        try {
            $query = "INSERT INTO logins_history (username) VALUES (:username)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Erro ao registrar login: " . $e->getMessage());
            return false;
        }
    }

    public function registerFailedAttempt($username)
    {
        try {
            $query = "INSERT INTO tentativas_login_malsucedido (username, data_tentativa, status) 
                     VALUES (:username, NOW(), 'ativa')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Erro ao registrar tentativa de login: " . $e->getMessage());
            return false;
        }
    }

    public function getFailedAttempts($username)
    {
        try {
            $query = "SELECT COUNT(*) FROM tentativas_login_malsucedido 
                     WHERE username = :username AND status = 'ativa'";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Erro ao obter tentativas de login: " . $e->getMessage());
            return 0;
        }
    }

    public function resetFailedAttempts($username)
    {
        try {
            $query = "UPDATE tentativas_login_malsucedido 
                     SET status = 'resetada' 
                     WHERE username = :username AND status = 'ativa'";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Erro ao resetar tentativas de login: " . $e->getMessage());
            return false;
        }
    }
}