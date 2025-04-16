<?php
// test_db.php
try {
    $dsn = "pgsql:host=10.1.129.38;port=5432;dbname=conectapapem";
    $username = "conectapapem_rw";
    $password = "C0n3ct@P@pem!RW2025";
    
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexão bem sucedida!";
    
    // Tenta uma consulta simples
    $stmt = $conn->query("SELECT 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<br>Consulta bem sucedida: " . print_r($result, true);
} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
