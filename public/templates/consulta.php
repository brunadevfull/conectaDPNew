<!-- /var/www/html/conectaPapem_DP/public/templates/consulta.php -->
<main class="main-container">
    <form id="formConsulta" class="fade-in" enctype="multipart/form-data" method="post">
        <div id="digenv">
            <input id="toggle-on" name="opcao" value="digitar" class="toggle toggle-left" onchange="mostrarOpcao('digitar')" type="radio">
            <label for="toggle-on" class="btn1">Digitar Dados<img src="../img/digitando3.png" alt="Ícone" style="width: 30px; height: 30px;"></label>
            <img src="../img/seta.png" alt="Ícone" style="width: 60px; height:30px;">
            <input id="toggle-off" name="opcao" class="toggle toggle-right" value="arquivo" onchange="mostrarOpcao('arquivo')" type="radio">
            <label for="toggle-off" class="btn1">Enviar Arquivo<img src="../img/arquivo2.png" alt="Ícone" style="width: 30px; height: 30px;">
        </div>


        <div>
            <div class="select-container">
                <select name="consultar" id="consultar" class="custom-select combobox-customizada" onchange="changeOption()">
                    <option class="custom-option" value="CPF">CPF</option>
                    <option class="custom-option" value="CNPJ">CNPJ</option>
                    <option class="custom-option" value="CNIS">CNIS</option>
                </select>
                <input type="hidden" id="opcao" name="opcao" value="">
            </div>
            <div id="cpfInput" style="display: none;">
                <input id="documento" name="documento" type="text" placeholder="Insira o CPF">
            </div>
            <div id="arquivoInput" style="display: none;">
                <label for="fileInput" class="custom-file-upload">
                    <img src="../img/xlsx.jpg" alt="Ícone" style="width:40px; height:40px; margin-right: 5px;">
                    <span id="fileLabelText">Importe seu arquivo</span>
                    <input type="file" name="fileInput" id="fileInput" accept=".xls, .xlsx">
                </label>
            </div>
            <div class="file-button-container">
                <label id="labelRemoveFileButton" style="display: none;" onclick="removeFile()">
                    Remover
                    <img id="removeFileButton" style="display: none;" src="../img/btn_x.png" alt="Remover">
                </label>
                <label id="labelChangeFileButton" style="display: none;" onclick="changeFile()">
                    Trocar
                    <img id="changeFileButton" style="display: none;" src="../img/btn_e.png" alt="Editar">
                </label>
            </div>
            <div id="loadingIndicator" style="display: none;">
                <span>Carregando</span>
                <div class="dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
            <div id="gridContainer"></div>
            <div class="input-container"></div>
            <button id="btn_consult" class="fade-in custom-button" style="display: none;" type="button" onclick="validateAndSubmit()">Consultar</button>
        </div>
    </form>

    <div id="jq">
        <table id="resultTable" class="display">
            <thead>
                <tr id="tableHeader"></tr>
            </thead>
            <tbody></tbody>
        </table>
        <div id="jqxgrid">
            <table id="tabelaResultado"></table>
        </div>
        <button id="btn_exportar_xlsx" style="display: none;" onclick="exportarXLSX()">Exportar para XLSX</button>
    </div>
</main>