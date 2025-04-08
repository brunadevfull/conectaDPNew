<?php
// app/Services/CadastroService.php
namespace App\Services;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class CadastroService
{
    private $usuarioRepository;

    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function cadastrarUsuario($username, $senha, $perfil)
    {
        // Limpar o NIP
        $nipLimpo = $this->limparNIP($username);
        if (!$nipLimpo) {
            return ["success" => false, "message" => "NIP deve conter exatamente 8 dígitos."];
        }

        // Verificar se o usuário já existe
        if ($this->usuarioRepository->exists($nipLimpo)) {
            return ["success" => false, "message" => "Usuário já existe."];
        }

        // Validar a senha
        if (!$this->validarSenha($senha)) {
            return ["success" => false, "message" => "Senha não atende aos critérios de segurança."];
        }

        // Criar hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Cadastrar o usuário
        $result = $this->usuarioRepository->create($nipLimpo, $senhaHash, $perfil);

        if ($result) {
            return ["success" => true, "message" => "Usuário cadastrado com sucesso."];
        } else {
            return ["success" => false, "message" => "Erro ao cadastrar usuário."];
        }
    }

    private function limparNIP($nip)
    {
        // Remove todos os caracteres não numéricos
        $nipLimpo = preg_replace('/\D/', '', $nip);
        // Verifica se o NIP limpo tem exatamente 8 dígitos
        return (strlen($nipLimpo) === 8) ? $nipLimpo : false;
    }

    private function validarSenha($senha)
    {
        $regraTamanho = strlen($senha) >= 12;
        $regraMaiuscula = preg_match('/[A-Z]/', $senha);
        $regraMinuscula = preg_match('/[a-z]/', $senha);
        $regraNumero = preg_match('/\d/', $senha);
        $regraEspecial = preg_match('/[^a-zA-Z\d]/', $senha);

        return $regraTamanho && $regraMaiuscula && $regraMinuscula && $regraNumero && $regraEspecial;
    }
}