
$(document).ready(function() {
   
    configurarPermissoesVisuais();
    $('#documento').on('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            validateAndSubmit();
        }
    });

    $('#fileInput').on('change', function(event) {
        updateFileLabelText(event);
    });

    $('#fileInput').on('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            validateAndSubmit();
        }
    });

    $('#consultar').on('change', function() {
        changeOption();
        applyMask(); // Chamar a função applyMask quando o tipo de consulta mudar
    });

    $('input[name="opcao"]').on('change', function() {
        mostrarOpcao(this.value);
    });

    previousOption = $('#consultar').val();

    
});

function configurarPermissoesVisuais() {
    const select = document.getElementById('consultar');
    const opcoes = select.querySelectorAll('option');

    // Esconde todas as opções
    opcoes.forEach(op => {
        if (op.value !== '') {
            op.style.display = 'none';
        }
    });

    // Exibe só as permitidas
    permissoesUsuario.forEach(recurso => {
        const option = select.querySelector(`option[value="${recurso.toUpperCase()}"]`);
        if (option) {
            option.style.display = 'block';
        }
    });

    // Seleciona a primeira opção visível permitida
    const primeira = [...select.options].find(opt => opt.style.display !== 'none' && opt.value !== '');
    if (primeira) {
        select.value = primeira.value;
        changeOption(); // Chama o comportamento normal
    }
}



function mostrarOpcao(opcao) {
    const cpfInput = document.getElementById('cpfInput');
    const arquivoInput = document.getElementById('arquivoInput');
    const consultarSelect = document.getElementById('consultar');

    if (opcao === 'digitar') {
        cpfInput.style.display = 'block';
        arquivoInput.style.display = 'none';
    } else if (opcao === 'arquivo') {
        cpfInput.style.display = 'none';
        arquivoInput.style.display = 'block';
        document.getElementById('documento').value = '';
    }

    // Reseta todas as opções
    const opcoes = consultarSelect.querySelectorAll('option');
    opcoes.forEach(op => {
        op.style.display = 'none';
    });

    // Aplica apenas os recursos permitidos
    permissoesUsuario.forEach(recurso => {
        const option = consultarSelect.querySelector(`option[value="${recurso.toUpperCase()}"]`);
        if (option) {
            option.style.display = 'block';
        }
    });

    // Seleciona a primeira opção visível
    const primeira = [...consultarSelect.options].find(opt => opt.style.display !== 'none');
    if (primeira) {
        primeira.selected = true;
    }

    clearAndHideGrid();
    hideFileButtons();
    toggleExportButton([]);
    applyMask();
    changeOption(); // Atualiza placeholder, máscara, etc.
}


function changeOption() {
    var selectedOption = document.getElementById('consultar').value; // Opção selecionada

console.log(document.querySelectorAll('input[name="opcao"]'));

    var opcaoElement = document.querySelector('input[name="opcao"]:checked');
var opcao = opcaoElement ? opcaoElement.value : null;
if (!opcao) {
    console.error("Nenhum botão com name='opcao' está selecionado ou não existe no DOM.");
    return; // Impede que a execução continue
}
console.log(document.querySelectorAll('input[name="opcao"]'));
    var documentoInput = document.getElementById('documento');


    // Limpar campos e ajustar visibilidade ao trocar a opção
    if ((previousOption === 'CPF' && selectedOption !== 'CPF') || 
        (previousOption === 'CNPJ' && selectedOption !== 'CNPJ') || 
        (previousOption === 'CNIS' && selectedOption !== 'CNIS') ||
        (previousOption !== 'arquivo' && opcao === 'arquivo') ||
        (previousOption === 'arquivo' && opcao !== 'arquivo')) {
        documentoInput.value = '';
        removeFile();
        clearAndHideGrid();
        if (opcao !== 'arquivo') {
            hideFileButtons(); // Esconder botões "Remover" e "Trocar"
        }
        toggleExportButton([]); // Esconder botão de exportação
    }

    // Configurar comportamento para cada opção
    if (opcao === 'digitar') {
        document.getElementById('consultar').style.display = 'block';
        document.getElementById('btn_consult').style.display = 'block';
        if (selectedOption === 'CPF') {
            documentoInput.placeholder = 'Insira o CPF';
            applyMask(); // Aplicar máscara de CPF
        } else if (selectedOption === 'CNPJ') {
            documentoInput.placeholder = 'Insira o CNPJ';
            applyMask(); // Aplicar máscara de CNPJ
        } else if (selectedOption === 'CNIS') {
            documentoInput.placeholder = 'Insira o CPF para CNIS';
            applyMask(); // CNIS usa a mesma máscara de CPF
        }
    } else if (opcao === 'arquivo') {
        document.getElementById('consultar').style.display = 'block';
        document.getElementById('btn_consult').style.display = 'block';
    }

    previousOption = selectedOption;
}
function toggleSenha() {
    const input = document.getElementById("senha");
    const icon = document.getElementById("toggleSenha");
  
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }
  
function applyMask() {
    var selectedOption = document.getElementById('consultar').value;
    var documentoInput = $('#documento'); // Certifique-se de que o elemento está sendo selecionado corretamente

    console.log('Aplicando máscara:', selectedOption, documentoInput); // Log para depuração

    if (selectedOption === 'CPF' || selectedOption === 'CNIS') {
        documentoInput.mask('000.000.000-00', {reverse: true}); // Máscara de CPF
    } else if (selectedOption === 'CNPJ') {
        documentoInput.mask('00.000.000/0000-00', {reverse: true}); // Máscara de CNPJ
    }
}

function validateAndSubmit() {
    var documentoInput = $('#documento').val().replace(/\D/g, '');
    var fileInput = $('#fileInput')[0].files[0];
    var selectedOption = $('#consultar').val();

    if (fileInput) {
        console.log('Arquivo selecionado, pulando validação de documento.');
        consultar();
        return;
    }

    console.log('Validando documento:', documentoInput);

    if ((selectedOption === 'CPF' && documentoInput.length !== 11) || 
        (selectedOption === 'CNPJ' && documentoInput.length !== 14) ||
        (selectedOption === 'CNIS' && documentoInput.length !== 11)) {
        alert('Por favor, insira um ' + selectedOption + ' válido.');
        return;
    }

    consultar();
}



function updateFileLabelText(event) {
    event.preventDefault();
    var input = document.getElementById('fileInput');
    var label = document.getElementById('fileLabelText');
    var removeButton = $('#removeFileButton');
    var changeButton = $('#changeFileButton');
    var labelRemove = $('#labelRemoveFileButton');
    var labelChange = $('#labelChangeFileButton');
    
    if (input.files && input.files.length > 0) {
        label.textContent = input.files[0].name;
        removeButton.show();
        changeButton.show();
        labelRemove.show();
        labelChange.show();
    } else {
        label.textContent = 'Importe seu arquivo';
        removeButton.hide();
        changeButton.hide();
        labelRemove.hide();
        labelChange.hide();
    }
}

function removeFile() {
    $('#fileInput').val('');
    $('#fileLabelText').text('Importe seu arquivo');
    hideFileButtons();
}

function hideFileButtons() {
    $('#removeFileButton').hide();
    $('#labelRemoveFileButton').hide(); 
    $('#changeFileButton').hide();
    $('#labelChangeFileButton').hide();
}

function changeFile() {
    $('#fileInput').click();
}

function toggleExportButton(data) {
    var exportButton = document.getElementById('btn_exportar_xlsx');
    if (Array.isArray(data) && data.length > 0) {
        exportButton.style.display = 'block'; 
    } else {
        exportButton.style.display = 'none'; 
    }
}

function formatDocumento(input) {
    var documento = input.value.replace(/\D/g, '');

    if (documento.length <= 11) {
        documento = documento.replace(/^(\d{3})(\d)/, '$1.$2');
        documento = documento.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        documento = documento.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
    } else {
        documento = documento.replace(/^(\d{2})(\d)/, '$1.$2');
        documento = documento.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        documento = documento.replace(/\.(\d{3})(\d)/, '.$1/$2');
        documento = documento.replace(/(\d{4})(\d)/, '$1-$2');
    }

    input.value = documento;
}

function clearAndHideGrid() {
    $("#jqxgrid").jqxGrid('clear');
    $("#jqxgrid").hide();
}

function redirecionarParaLogin() {
    window.location.href = 'login.php';
}

const tempoLimiteSegundos = 800; 

let temporizadorInatividade = setTimeout(redirecionarParaLogin, tempoLimiteSegundos * 1000);

document.addEventListener('mousemove', reiniciarTemporizador);
document.addEventListener('keypress', reiniciarTemporizador);

function reiniciarTemporizador() {
    clearTimeout(temporizadorInatividade);
    temporizadorInatividade = setTimeout(redirecionarParaLogin, tempoLimiteSegundos * 1000);
}

function updateHiddenField() {
    var selectedOption = document.getElementById("consultar").value;
    document.getElementById("opcao").value = selectedOption;
}
