<?php
// app/Core/EnvLoader.php
namespace App\Core;

class EnvLoader
{
    /**
     * Carrega as variáveis de ambiente a partir de um arquivo .env
     * 
     * @param string $path Caminho para o arquivo .env
     * @return bool True se o arquivo foi carregado com sucesso, false caso contrário
     */
    public static function load($path = null)
    {
        // Caminho padrão para o arquivo .env
        if ($path === null) {
            $path = __DIR__ . '/../../.env';
        }
        
        // Verifica se o arquivo existe
        if (!file_exists($path)) {
            error_log("Arquivo .env não encontrado em: $path");
            return false;
        }
        
        // Carrega o arquivo linha por linha
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignora comentários
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Processa apenas linhas com '='
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                
                // Define as variáveis de ambiente
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
        
        return true;
    }
}