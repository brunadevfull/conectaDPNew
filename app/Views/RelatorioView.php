<?php
// app/Views/RelatorioView.php
namespace App\Views;

class RelatorioView
{
    public function exibirRelatorio($statistics)
    {
        // Os dados estatísticos já estão formatados e prontos para serem enviados ao template
        include __DIR__ . '/../../public/templates/relatorio.php';
    }
}