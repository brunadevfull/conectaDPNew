<?php
// app/Repositories/ConsultaRepository.php
namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Interfaces\ConsultaRepositoryInterface;

class ConsultaRepository implements ConsultaRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function registerConsulta($username, $documento, $tipoDocumento)
    {
        try {
            $query = "INSERT INTO consultas_usuario (username, " . ($tipoDocumento === 'CPF' ? 'cpf' : 'cnpj') . ", data_consulta, tipo_documento) 
                    VALUES (:username, :documento, CURRENT_TIMESTAMP, :tipo_documento)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':tipo_documento', $tipoDocumento);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Erro ao registrar consulta: " . $e->getMessage());
            return false;
        }
    }

    public function getFailedLoginsByMonth()
    {
        try {
            $query = "SELECT COUNT(*) AS total, EXTRACT(MONTH FROM data_tentativa) AS mes 
                    FROM tentativas_login_malsucedido 
                    GROUP BY EXTRACT(MONTH FROM data_tentativa)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao contar tentativas de login malsucedidas: " . $e->getMessage());
            return [];
        }
    }

    public function getConsultasByMonth()
    {
        try {
            $query = "SELECT COUNT(*) AS total, EXTRACT(MONTH FROM data_consulta) AS mes, tipo_documento 
                    FROM consultas_usuario 
                    GROUP BY EXTRACT(MONTH FROM data_consulta), tipo_documento";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao contar consultas por mês: " . $e->getMessage());
            return [];
        }
    }
}