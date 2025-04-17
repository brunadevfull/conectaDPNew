<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatórios - Conecta PAPEM</title>
    <link rel="stylesheet" type="text/css" href="../css/global.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300,700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/../header.php'; ?>
    
    <main class="container">
        <h1>Estatísticas do Sistema</h1>
        
        <section class="chart-container">
            <h2>Tentativas de Login Malsucedidas por Mês</h2>
            <canvas id="loginChart"></canvas>
        </section>
        
        <section class="chart-container">
            <h2>Consultas de CPF por Mês</h2>
            <canvas id="cpfChart"></canvas>
        </section>
        
        <section class="chart-container">
            <h2>Consultas de CNPJ por Mês</h2>
            <canvas id="cnpjChart"></canvas>
        </section>
        
        <section class="chart-container">
            <h2>Consultas de CNIS por Mês</h2>
            <canvas id="cnisChart"></canvas>
        </section>
    </main>
    
    <?php include __DIR__ . '/../footer.php'; ?>
    
    <script>
        // Dados recebidos do PHP
        const loginData = <?php echo json_encode($statistics['login']); ?>;
        const cpfData = <?php echo json_encode($statistics['cpfConsultas']); ?>;
        const cnpjData = <?php echo json_encode($statistics['cnpjConsultas']); ?>;
        const cnisData = <?php echo json_encode($statistics['cnisConsultas']); ?>;
        
        // Opções comuns para os gráficos
        const chartOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };
        
        // Renderizar gráficos
        window.onload = function() {
            // Gráfico de logins malsucedidos
            new Chart(document.getElementById('loginChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(loginData),
                    datasets: [{
                        label: 'Tentativas Malsucedidas',
                        data: Object.values(loginData),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: chartOptions
            });
            
            // Gráfico de consultas de CPF
            new Chart(document.getElementById('cpfChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(cpfData),
                    datasets: [{
                        label: 'Consultas de CPF',
                        data: Object.values(cpfData),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: chartOptions
            });
            
            // Gráfico de consultas de CNPJ
            new Chart(document.getElementById('cnpjChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(cnpjData),
                    datasets: [{
                        label: 'Consultas de CNPJ',
                        data: Object.values(cnpjData),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: chartOptions
            });
            
            // Gráfico de consultas de CNIS
            new Chart(document.getElementById('cnisChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(cnisData),
                    datasets: [{
                        label: 'Consultas de CNIS',
                        data: Object.values(cnisData),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: chartOptions
            });
        };
    </script>
</body>
</html>