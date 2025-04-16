<!-- File: app/Views/pages/consulta.php -->
<div class="container mx-auto px-4 pb-12">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Consulta de Dados</h1>
        <p class="text-center text-gray-600 mb-8">Escolha o tipo de dado e como deseja fornecer as informações.</p>
        
        <form id="formConsulta" class="space-y-8" enctype="multipart/form-data" method="post">
            <!-- Tipo de Dado selection -->
            <div class="flex items-center space-x-4 justify-center">
                <label for="consultar" class="text-gray-700 font-medium w-32">Tipo de Dado:</label>
                <select name="consultar" id="consultar" 
                        class="py-2 px-4 w-64 border border-gray-300 rounded-md bg-white text-gray-700 appearance-none cursor-pointer" 
                        onchange="changeOption()">
                    <option value="CPF">CPF</option>
                    <option value="CNPJ">CNPJ</option>
                    <option value="CNIS">CNIS</option>
                </select>
            </div>
            
            <!-- Toggle buttons for input method -->
            <div class="flex justify-center items-center space-x-4">
                <input id="toggle-on" name="opcao" value="digitar" class="hidden" type="radio">
                <label for="toggle-on" id="btn-digitar" 
                       class="border-2 border-gray-800 py-3 px-4 inline-flex flex-col items-center justify-center w-40 h-24 bg-white hover:bg-gray-100 cursor-pointer"
                       onclick="mostrarOpcao('digitar')">
                    <span class="mb-2">Digitar Dados</span>
                    <img src="/img/digitando3.png" alt="Digitar Dados" class="w-8 h-8">
                </label>
                
                <span class="text-gray-500 px-2">ou</span>
                
                <input id="toggle-off" name="opcao" value="arquivo" class="hidden" type="radio">
                <label for="toggle-off" id="btn-arquivo" 
                       class="border-2 border-gray-800 py-3 px-4 inline-flex flex-col items-center justify-center w-40 h-24 bg-white hover:bg-gray-100 cursor-pointer"
                       onclick="mostrarOpcao('arquivo')">
                    <span class="mb-2">Enviar Arquivo</span>
                    <img src="/img/arquivo2.png" alt="Enviar Arquivo" class="w-8 h-8">
                </label>
            </div>
            
            <input type="hidden" id="opcao" name="opcao" value="">
            
            <!-- Input fields (initially hidden) -->
            <div id="cpfInput" class="hidden mx-auto max-w-md">
                <input id="documento" name="documento" type="text" placeholder="Insira o CPF"
                       class="w-full py-3 px-4 border border-gray-300 rounded-md text-gray-700">
            </div>
            
            <div id="arquivoInput" class="hidden mx-auto max-w-md">
                <label for="fileInput" 
                       class="flex items-center justify-center space-x-3 py-3 px-4 border border-gray-300 rounded-md bg-white text-gray-700 cursor-pointer hover:bg-gray-50">
                    <img src="/img/xlsx.jpg" alt="Ícone" class="w-10 h-10">
                    <span id="fileLabelText">Importe seu arquivo</span>
                    <input type="file" name="fileInput" id="fileInput" accept=".xls, .xlsx"
                           class="hidden">
                </label>
            </div>
            
            <!-- File handling buttons -->
            <div class="flex justify-center items-center space-x-4">
                <label id="labelRemoveFileButton" class="hidden cursor-pointer text-red-600 flex items-center" onclick="removeFile()">
                    Remover
                    <img id="removeFileButton" class="hidden w-5 h-5 ml-1" src="/img/btn_x.png" alt="Remover">
                </label>
                <label id="labelChangeFileButton" class="hidden cursor-pointer text-blue-600 flex items-center" onclick="changeFile()">
                    Trocar
                    <img id="changeFileButton" class="hidden w-5 h-5 ml-1" src="/img/btn_e.png" alt="Editar">
                </label>
            </div>
            
            <!-- Loading indicator -->
            <div id="loadingIndicator" class="hidden text-center">
                <span>Carregando</span>
                <div class="inline-flex">
                    <div class="w-2 h-2 rounded-full bg-black mx-1 animate-pulse" style="animation-delay: -0.32s"></div>
                    <div class="w-2 h-2 rounded-full bg-black mx-1 animate-pulse" style="animation-delay: -0.16s"></div>
                    <div class="w-2 h-2 rounded-full bg-black mx-1 animate-pulse"></div>
                </div>
            </div>
            
            <!-- Grid container for results -->
            <div id="gridContainer"></div>
            
            <!-- Submit button -->
            <div class="text-center">
                <button id="btn_consult" 
                        class="hidden py-3 px-6 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors mx-auto"
                        type="button" 
                        onclick="validateAndSubmit()">
                    Consultar
                </button>
            </div>
        </form>
        
        <!-- Results section -->
        <div id="jq" class="mt-8 w-full">
            <table id="resultTable" class="hidden w-full border-collapse">
                <thead>
                    <tr id="tableHeader" class="bg-gray-100"></tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="jqxgrid" class="mt-5 mb-5">
                <table id="tabelaResultado"></table>
            </div>
            <div class="text-center">
                <button id="btn_exportar_xlsx" 
                        class="hidden py-2 px-4 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition-colors" 
                        onclick="exportarXLSX()">
                    Exportar para XLSX
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle the toggle buttons
    function mostrarOpcao(opcao) {
        // Update hidden input value
        document.getElementById('opcao').value = opcao;
        
        // Highlight selected button
        document.getElementById('btn-digitar').classList.remove('bg-blue-100', 'border-blue-500');
        document.getElementById('btn-arquivo').classList.remove('bg-blue-100', 'border-blue-500');
        
        if (opcao === 'digitar') {
            document.getElementById('btn-digitar').classList.add('bg-blue-100', 'border-blue-500');
            document.getElementById('cpfInput').classList.remove('hidden');
            document.getElementById('arquivoInput').classList.add('hidden');
        } else {
            document.getElementById('btn-arquivo').classList.add('bg-blue-100', 'border-blue-500');
            document.getElementById('arquivoInput').classList.remove('hidden');
            document.getElementById('cpfInput').classList.add('hidden');
        }
        
        // Show consult button
        document.getElementById('btn_consult').classList.remove('hidden');
    }
    
    // Handle file selection
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Importe seu arquivo';
        document.getElementById('fileLabelText').textContent = fileName;
        
        if (e.target.files[0]) {
            document.getElementById('removeFileButton').classList.remove('hidden');
            document.getElementById('changeFileButton').classList.remove('hidden');
            document.getElementById('labelRemoveFileButton').classList.remove('hidden');
            document.getElementById('labelChangeFileButton').classList.remove('hidden');
        }
    });
    
    // Remove file function
    function removeFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('fileLabelText').textContent = 'Importe seu arquivo';
        document.getElementById('removeFileButton').classList.add('hidden');
        document.getElementById('changeFileButton').classList.add('hidden');
        document.getElementById('labelRemoveFileButton').classList.add('hidden');
        document.getElementById('labelChangeFileButton').classList.add('hidden');
    }
    
    // Change file function
    function changeFile() {
        document.getElementById('fileInput').click();
    }
</script>