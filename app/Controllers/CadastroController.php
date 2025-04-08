<?php
// app/Controllers/CadastroController.php
namespace App\Controllers;

use App\Services\CadastroService;
use App\Views\CadastroView;

class CadastroController
{
    private $cadastroService;
    private $view;

    public function __construct(CadastroService $cadastroService, CadastroView $view)
    {
        $this->cadastroService = $cadastroService;
        $this->view = $view;
    }

    public function cadastrar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $senha = $_POST['senha'];
            $perfil = $_POST['perfil'];

            $result = $this->cadastroService->cadastrarUsuario($username, $senha, $perfil);

            if ($result['success']) {
                $this->view->exibirMensagemSucesso($result['message'], '/conectaPapem/public/cadastroView.php');
            } else {
                $this->view->exibirMensagemErro($result['message']);
            }
        }
    }
}