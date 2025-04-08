<?php
// app/Models/Usuario.php
namespace App\Models;

class Usuario
{
    private $id;
    private $username;
    private $senha;
    private $perfil;
    private $statusBloqueio;
    private $dataBloqueio;
    private $lastLogin;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->senha = $data['senha'] ?? '';
        $this->perfil = $data['perfil'] ?? 'usuario';
        $this->statusBloqueio = $data['status_bloqueio'] ?? 'ativo';
        $this->dataBloqueio = $data['data_bloqueio'] ?? null;
        $this->lastLogin = $data['last_login'] ?? null;
    }

    // Getters e Setters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getSenha() { return $this->senha; }
    public function getPerfil() { return $this->perfil; }
    public function getStatusBloqueio() { return $this->statusBloqueio; }
    public function getDataBloqueio() { return $this->dataBloqueio; }
    public function getLastLogin() { return $this->lastLogin; }
    
    public function setUsername($username) { $this->username = $username; }
    public function setSenha($senha) { $this->senha = $senha; }
    public function setPerfil($perfil) { $this->perfil = $perfil; }
    public function setStatusBloqueio($statusBloqueio) { $this->statusBloqueio = $statusBloqueio; }
    public function setDataBloqueio($dataBloqueio) { $this->dataBloqueio = $dataBloqueio; }
    public function setLastLogin($lastLogin) { $this->lastLogin = $lastLogin; }

    // Métodos de validação
    public function isAdmin()
    {
        return $this->perfil === 'admin';
    }

    public function isBloqueado()
    {
        return $this->statusBloqueio === 'bloqueado';
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'senha' => $this->senha,
            'perfil' => $this->perfil,
            'status_bloqueio' => $this->statusBloqueio,
            'data_bloqueio' => $this->dataBloqueio,
            'last_login' => $this->lastLogin
        ];
    }
}