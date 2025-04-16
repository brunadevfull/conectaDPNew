<!-- /var/www/html/conectaPapem_DP/public/templates/consulta.php -->
<main class="flex flex-col relative bg-white border border-gray-300 shadow-md rounded-lg p-8 w-full max-w-4xl mx-auto my-12 min-h-[320px] opacity-0 transform -translate-y-5 animate-fade-in-up">
    <!-- External jQWidgets resources (leave as is) -->
    <link rel="stylesheet" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
    <script src="https://jqwidgets.com/public/jqwidgets/jqxcore.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxdata.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxbuttons.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxscrollbar.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxmenu.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxgrid.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxgrid.selection.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxgrid.columnsresize.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxgrid.filter.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxgrid.sort.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxgrid.pager.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxlistbox.js"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqxdropdownlist.js"></script>
    
    <form id="formConsulta" class="animate-fade-in" enctype="multipart/form-data" method="post">
        <div id="digenv" class="flex items-center justify-center mb-6">
            <!-- Toggle buttons with Tailwind -->
            <input id="toggle-on" name="opcao" value="digitar" class="hidden" onchange="mostrarOpcao('digitar')" type="radio">
            <label for="toggle-on" class="relative border-2 border-gray-800 inline-flex flex-col items-center p-3 cursor-pointer w-24 h-20 text-center transition-all duration-500 overflow-hidden">
                Digitar Dados
                <img src="../img/digitando3.png" alt="Ícone" class="w-8 h-8 my-1">
            </label>
            
            <img src="../img/seta.png" alt="Ícone" class="w-16 h-8 mx-2">
            
            <input id="toggle-off" name="opcao" class="hidden" value="arquivo" onchange="mostrarOpcao('arquivo')" type="radio">
            <label for="toggle-off" class="relative border-2 border-gray-800 inline-flex flex-col items-center p-3 cursor-pointer w-24 h-20 text-center transition-all duration-500 overflow-hidden">
                Enviar Arquivo
                <img src="../img/arquivo2.png" alt="Ícone" class="w-8 h-8 my-1">
            </label>
        </div>

        <div>
            <div class="flex justify-center mb-4">
                <select name="consultar" id="consultar" 
                        class="py-2 px-4 border border-gray-300 rounded-md bg-gray-50 text-gray-700 appearance-none cursor-pointer w-11/12" 
                        onchange="changeOption()">
                    <option value="CPF">CPF</option>
                    <option value="CNPJ">CNPJ</option>
                    <option value="CNIS">CNIS</option>
                </select>
                <input type="hidden" id="opcao" name="opcao" value="">
            </div>
            
            <div id="cpfInput" class="hidden w-4/5 mx-auto transform translate-x-[10%] rounded-md">
                <input id="documento" name="documento" type="text" placeholder="Insira o CPF"
                       class="w-full py-2.5 px-4 rounded-md border border-gray-300 text-sm">
            </div>
            
            <div id="arquivoInput" class="hidden w-4/5 mx-auto transform translate-x-[10%] rounded-md">
                <label for="fileInput" 
                       class="cursor-pointer relative overflow-hidden inline-flex items-center border border-gray-300 rounded-md p-3 bg-gray-50 text-gray-700">
                    <img src="../img/xlsx.jpg" alt="Ícone" class="w-10 h-10 mr-2">
                    <span id="fileLabelText">Importe seu arquivo</span>
                    <input type="file" name="fileInput" id="fileInput" accept=".xls, .xlsx"
                           class="absolute top-0 right-0 opacity-0 cursor-pointer">
                </label>
            </div>
            
            <div class="flex justify-center items-center mt-3">
                <label id="labelRemoveFileButton" class="hidden cursor-pointer mx-2" onclick="removeFile()">
                    Remover
                    <img id="removeFileButton" class="hidden w-5 h-5 ml-1" src="../img/btn_x.png" alt="Remover">
                </label>
                <label id="labelChangeFileButton" class="hidden cursor-pointer mx-2" onclick="changeFile()">
                    Trocar
                    <img id="changeFileButton" class="hidden w-5 h-5 ml-1" src="../img/btn_e.png" alt="Editar">
                </label>
            </div>
            
            <div id="loadingIndicator" class="hidden text-center py-5">
                <span>Carregando</span>
                <div class="inline-flex">
                    <div class="w-2 h-2 rounded-full bg-black mx-1 animate-pulse" style="animation-delay: -0.32s"></div>
                    <div class="w-2 h-2 rounded-full bg-black mx-1 animate-pulse" style="animation-delay: -0.16s"></div>
                    <div class="w-2 h-2 rounded-full bg-black mx-1 animate-pulse"></div>
                </div>
            </div>
            
            <div id="gridContainer"></div>
            <div class="input-container"></div>
            
            <button id="btn_consult" 
                    class="hidden mx-auto mt-5 mb-2 py-2.5 px-5 w-4/5 border border-blue-500 rounded-md bg-blue-500 text-white font-bold text-center cursor-pointer shadow-sm transition-all hover:bg-blue-600 hover:border-blue-600 animate-fade-in" 
                    type="button" 
                    onclick="validateAndSubmit()">
                Consultar
            </button>
        </div>
    </form>

    <div id="jq" class="mt-20 w-4/5 max-w-xl flex flex-col items-center">
        <table id="resultTable" class="display">
            <thead>
                <tr id="tableHeader"></tr>
            </thead>
            <tbody></tbody>
        </table>
        <div id="jqxgrid" class="mt-5 mb-12 overflow-y-auto ml-20">
            <table id="tabelaResultado"></table>
        </div>
        <button id="btn_exportar_xlsx" 
                class="hidden ml-20 py-2.5 px-5 border border-blue-500 rounded-md bg-blue-500 text-white text-center cursor-pointer shadow-sm transition-all hover:bg-blue-600" 
                onclick="exportarXLSX()">
            Exportar para XLSX
        </button>
    </div>
</main>
