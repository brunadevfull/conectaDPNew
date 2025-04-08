<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conecta PAPEM</title>
    <style>
     
    </style>
</head>

<body>
    <header id="topo" class="fixar_barra_superior">
    <div class="container">
        <div class="container" id="header-center">
            <div class="row">
                <div class="col-6 header-logo-area">
                    <div>
                        <div id="block-mb01-branding">
                            <div class="branding-area">
                                <div class="btn-menu-principal-area"></div>
                                <div class="area-logo">
                                    <a href="/conectaPapem/public/" rel="home">
                                        <div class="site-area-logo">
                                            <img src="../img/brasao.png" alt="Início">
                                            <div class="site-name-area">
                                            <h1 class="site-name">Marinha do Brasil</h1>
                                                <h6 class="bottom-site-name">Protegendo as nossas riquezas, cuidando da nossa gente</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 header-right-area">
                    <div>
                        <div class="ods-area-links">
                            <ul>
                                <li><img src="../img/conecta-gov.png" alt="Início"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Centralizar o texto "Conecta Papem" -->
        <div class="text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <div style="display: inline-flex; align-items: center;">
        <!-- Brasão -->
        <img src="../img/brasao2.png" alt="Brasão" style="height: 5rem; margin-right: 1rem; margin-bottom: 0.5rem;">

        <!-- Texto: Conecta PAPEM -->
        <div style="text-align: center;">
            <span style="display: block; font-family: 'Good Times RG', sans-serif; font-size: 2rem; color: white; line-height: 1;">CONECTA</span>
            <span style="display: block; font-family: 'Good Times RG', sans-serif; font-size: 2rem; color: white; line-height: 1;">PAPEM</span>
        </div>

        <!-- Folha -->
        <img src="../img/folha.png" alt="Folha" style="height: 5rem; margin-left: 1rem; margin-bottom: 0.5rem;">
    </div>
</div>

        <div class="header-bottom-area-bg">
            <div class="container" >
                <div class="row">
                    <div class="col header-bottom">
                        <div>
                            <div  id="block-header-bottom-area-menu-rapido">
                                <div class="layout layout--onecol">
                                    <div class="layout__region layout__region--content">
                                        <div>
                                            <div class="menu-links-area">
                                            <ul  class="links-uteis">
                                                    <?php if (isset($nomeUsuario) && $nomeUsuario): ?>
                                                        <li  id="bem-vindo" class="item"><a href="../public/">Bem-vindo, <?php echo $nomeUsuario; ?>!</a></li>
                                               

                                                    <?php if (isset($perfilUsuario) && $perfilUsuario === 'admin'): ?>
                                                        <li ><a href="relatorio.php">Relatórios</a></li>
                                                    <?php endif; ?>

                                                    <?php if (isset($perfilUsuario) && $perfilUsuario === 'admin'): ?>
                                                        <li ><a href="cadastroView.php">Cadastrar Usuário</a></li>
                                                    <?php endif; ?>

                                            
                                                        <li ><a href="logout.php">Logout</a></li>
                                                 
                                                 </ul>
                                                        </div>
                                                   
                                               
                                            </div>
                                            <div id="disclaimer">
                                                <label> Aviso: As informações consultadas por meio deste sistema são oriundas do Conecta gov.br, que é uma iniciativa da Secretaria de Governo Digital para os Órgãos e Entidades do Poder Executivo Federal.</label>
                                            </div> <?php endif; ?>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</html>