<?php
// app/Controllers/ConsultaController.php
namespace App\Controllers;

use App\Services\AuthService;
use App\Services\ConsultaService;
use App\Factories\DocumentValidatorFactory;
use App\Views\ConsultaView;

class ConsultaController
{
    private $authService;
    private $consultaService;
    private $view;

    public function __construct(
        AuthService $authService,
        ConsultaService $consultaService,
        ConsultaView $view
    ) {
        $this->authService = $authService;
        $this->consultaService = $consultaService;
        $this->view = $view;
    }

  // app/Controllers/ConsultaController.php
public function autenticar()
{
    // Remova ou modifique esta linha para verificar se a sessão já está ativa
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $result = $this->authService->authenticate($username, $senha);

        if ($result['success']) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $this->view->exibirMensagemErro($result['message']);
        }
    }
}
    public function consultar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $username = $_SESSION['username'] ?? 'guest';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $opcao = $_POST['opcao'] ?? null;
            if (!$opcao) {
                echo json_encode(['error' => 'Opção inválida.']);
                exit;
            }

            $documento = $_POST['documento'] ?? null;
            $fileInput = $_FILES['fileInput'] ?? null;

            try {
                // Validar documento ou documentos do arquivo
                if (!empty($_POST['documento'])) {
                    $documento = preg_replace('/[^0-9]/', '', $documento);
                    
                    $validator = DocumentValidatorFactory::create($opcao);
                    if (!$validator->validate($documento)) {
                        echo json_encode(['error' => 'Documento inválido.']);
                        return;
                    }
                    
                    $documentArray = [$documento];
                } elseif ($fileInput && $fileInput['tmp_name']) {
                    $documentArray = $this->consultaService->readDocumentsFromExcel($fileInput['tmp_name']);
                    
                    $validator = DocumentValidatorFactory::create($opcao);
                    foreach ($documentArray as $doc) {
                        if (empty($doc)) {
                            continue;
                        }
                        
                        if (!$validator->validate($doc)) {
                            echo json_encode(['error' => "$opcao inválido no arquivo: $doc"]);
                            return;
                        }
                    }
                } else {
                    echo json_encode(['error' => "Nenhum documento fornecido."]);
                    return;
                }

                // Registrar consultas
                foreach ($documentArray as $doc) {
                    if (empty($doc)) {
                        continue;
                    }
                    $this->consultaService->registerConsulta($username, $doc, $opcao);
                }

                // Realizar consulta na API
                $result = $this->consultaService->performConsulta($opcao, $documentArray);
                echo json_encode($result);
                exit;
            } catch (\Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
    }
}