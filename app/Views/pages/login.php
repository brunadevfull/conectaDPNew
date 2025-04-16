<!-- File: app/Views/pages/login.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    
    <!-- Replace multiple CSS files with Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/conectaPapem/css/tailwind.css">
    
    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="../js/utils.js"></script>

    <script>
        $(document).ready(function() {
            // Aplicar máscara ao campo de username
            $('input[name="username"]').mask('00.0000.00'); // Formato 11.1110.62

            $('form').submit(function(e) {
                e.preventDefault();

                var usernameValue = $('input[name="username"]').val().replace(/\./g, ''); // Remover os pontos
                var senhaValue = $('input[name="senha"]').val();

                // Cria um formulário oculto para envio dos dados sem os pontos
                var form = $('<form>', {
                    'method': 'POST',
                    'action': $(this).attr('action')
                }).append($('<input>', {
                    'type': 'hidden',
                    'name': 'username',
                    'value': usernameValue
                })).append($('<input>', {
                    'type': 'hidden',
                    'name': 'senha',
                    'value': senhaValue
                }));

                // Mostrar o loader
                document.getElementById('loader').classList.remove('hidden');
                
                $('body').append(form);
                form.submit();
            });

            window.addEventListener('load', function () {
                document.getElementById('loader').classList.add('hidden');
            });
        });
    </script>
</head>
<body class="bg-gradient-to-b from-blue-50 to-blue-100">
    <?php 
    // Incluir o header se disponível
    $headerPath = __DIR__ . '/../../Views/layouts/header.php';
    if (file_exists($headerPath)) {
        include($headerPath);
    }
    ?>
    
    <main class="flex justify-center items-center min-h-[80vh] p-5 mt-24">
        <section class="bg-white rounded-xl shadow-lg py-8 px-6 w-full max-w-sm h-[350px]">
            <h2 class="flex items-center justify-center gap-2 text-xl font-bold text-gray-800 mb-5">
                <i class="fas fa-user-circle text-blue-500 mr-2"></i>LOGIN
            </h2>
            
            <?php if (isset($errorMessage)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="bg-white rounded-lg shadow-md p-6">
                <div class="relative mb-5">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input type="text" 
                           name="username" 
                           placeholder="Insira seu NIP" 
                           class="w-full py-3 px-4 pl-10 rounded-md border border-gray-300 bg-gray-50 text-sm transition-all focus:outline-none focus:border-blue-500 focus:bg-white" 
                           required>
                </div>
                
                <div class="relative mb-5">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input type="password" 
                           name="senha" 
                           placeholder="Insira sua senha" 
                           class="w-full py-3 px-4 pl-10 rounded-md border border-gray-300 bg-gray-50 text-sm transition-all focus:outline-none focus:border-blue-500 focus:bg-white" 
                           required>
                </div>
                
                <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-b from-blue-500 to-blue-700 text-white font-bold border-none rounded-lg text-sm cursor-pointer transition-all hover:from-blue-600 hover:to-blue-800 hover:transform hover:-translate-y-0.5">
                    Entrar
                </button>
                
                <div id="loader" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
                    <div class="border-4 border-gray-200 border-t-blue-500 rounded-full w-16 h-16 animate-spin"></div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>