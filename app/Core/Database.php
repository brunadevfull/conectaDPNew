<?php
// app/Core/Database.php
namespace App\Core;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Para testes, vamos usar os valores diretamente em vez de carregar do .env
        try {
            $host = '10.1.129.38';
            $port = '5432';
            $dbname = 'conectapapem';
            $username = 'conectapapem_rw';
            $password = 'C0n3ct@P@pem!RW2025';
            
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            
            $this->connection = new \PDO($dsn, $username, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            error_log("Conexão com o banco de dados estabelecida com sucesso");
        } catch (\PDOException $e) {
            error_log("Erro de conexão com o banco: " . $e->getMessage());
            throw new \Exception("Database connection error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    // Prevent cloning of the instance
    public function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {}
}