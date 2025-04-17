<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Conecta PAPEM' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include jQWidgets only if needed on the current page -->
    <?php if (isset($includeJqWidgets) && $includeJqWidgets): ?>
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
    <?php endif; ?>
    <link rel="stylesheet" href="ConectaPapem_DP/../../public/css/tailwind.css">
    <link href="ConectaPapem_DP/../../public/css/custom.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <!-- User permissions script -->
    <script>
        var permissoesUsuario = <?php 
            echo isset($_SESSION['permissoes']) ? json_encode($_SESSION['permissoes']) : '[]'; 
        ?>;
    </script>
    
    <!-- Custom scripts -->
    <script src="/js/utils.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-blue-50 to-blue-100">
    <header id="topo" class="fixed w-full z-50 top-0 bg-blue-700 h-36">
        <div class="container mx-auto px-4">
            <div class="container mx-auto px-4" id="header-center">
                <div class="flex flex-wrap">
                    <div class="w-1/2 flex items-center">
                        <div>
                            <div id="block-mb01-branding">
                                <div class="flex items-center">
                                    <div class="btn-menu-principal-area"></div>
                                    <div class="flex items-center">
                                        <a href="/conectaPapem/public/" rel="home" class="flex items-center">
                                            <div class="flex items-center">
                                                <img src="/img/brasao.png" alt="Início" class="h-16 mt-4 mr-2">
                                                <div class="text-white">
                                                    <h1 class="text-xl font-bold font-sans">Marinha do Brasil</h1>
                                                    <h6 class="text-xs font-normal">Protegendo as nossas riquezas, cuidando da nossa gente</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 flex justify-end items-center">
                        <div>
                            <div class="flex justify-end">
                                <ul>
                                    <li><img src="/img/conecta-gov.png" alt="Início"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Centralized "Conecta Papem" text -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                <div class="flex items-center">
                    <img src="/img/brasao2.png" alt="Brasão" class="h-20 mr-4 mb-2">
                    <div class="text-center">
                        <span class="block font-sans text-2xl text-white leading-none">CONECTA</span>
                        <span class="block font-sans text-2xl text-white leading-none">PAPEM</span>
                    </div>
                    <img src="/img/folha.png" alt="Folha" class="h-20 ml-4 mb-2">
                </div>
            </div>

            <div class="bg-blue-800 absolute bottom-0 w-full">
                <div class="container mx-auto px-4">
                    <div class="flex flex-wrap">
                        <div class="w-full">
                            <div>
                                <div id="block-header-bottom-area-menu-rapido">
                                    <div class="layout">
                                        <div class="layout-content">
                                            <div>
                                                <div class="py-1">
                                                    <ul class="flex space-x-4 text-white text-sm">
                                                        <?php if (isset($nomeUsuario) && $nomeUsuario): ?>
                                                            <li id="bem-vindo" class="float-left"><a href="/" class="hover:text-blue-200">Bem-vindo, <?php echo $nomeUsuario; ?>!</a></li>
                                                       
                                                            <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                                                                <li><a href="/relatorio" class="hover:text-blue-200">Relatórios</a></li>
                                                                <li><a href="/cadastro" class="hover:text-blue-200">Cadastrar Usuário</a></li>
                                                            <?php endif; ?>
                                                            
                                                            <li><a href="/logout" class="hover:text-blue-200">Logout</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                                
                                                <?php if (isset($nomeUsuario) && $nomeUsuario): ?>
                                                <div id="disclaimer" class="relative mt-2 text-xs bg-gray-100 text-center p-1">
                                                    <label> Aviso: As informações consultadas por meio deste sistema são oriundas do Conecta gov.br, que é uma iniciativa da Secretaria de Governo Digital para os Órgãos e Entidades do Poder Executivo Federal.</label>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <main class="pt-40">