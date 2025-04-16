<?php

require_once 'config/Database.php';

$db = new Database();
$conexao = $db->getConnection();


require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/Controllers/ConsultaController.php';
require __DIR__ .'/app/Views/ConsultaView.php';
use App\Controllers\ConsultaController;

$controller = new ConsultaController();
$cpfData = $controller->consultar(); 

$view = new App\Views\ConsultaView();

if (!empty($cpfData)) {
    $view->exibirResultados($cpfData); // Certifique-se de passar os dados corretos aqui
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesquisa de CPF</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/consultar.js"></script>
</head>

<body>
    <header>
        <div class="brasao-container">
            <img src="brasao.png" alt="Brasão PAPEM" width="90"/>
            <div class="titulo-container">
                <span class="span-subtitulo-marinha">Marinha do Brasil</span>
                <h1>Pagadoria de Pessoal da Marinha</h1>
                <span class="span-subtitulo-lema">"ORDEM, PRONTIDÃO E REGULARIDADE"</span>
            </div>
        </div>
    </header>

    <main>
    <h1 id="conecta">ConectaPAPEM</h1>
<input id="documento" type="text" placeholder="Insira o CPF ou CNPJ">

<form id="formConsulta" enctype="multipart/form-data">
    <select name="consultar" id="consultar" onchange="changeOption()">
        <option value="CPF">CPF</option>
        <option value="CNPJ">CNPJ</option>
        <!-- Adicione outras opções aqui conforme necessário -->
    </select>
    
    <input type="file" name="fileInput" id="fileInput" accept=".xls, .xlsx">

</form>
<button type="button" onclick="consultar()">Consultar</button>
        
      

        <div id="resultado">
          
        </div>
    </main>

    <footer>
        <span>©PAPEM — 2023</span>
    </footer>
</body>
</html>
