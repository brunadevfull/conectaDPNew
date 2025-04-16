<?php
// app/Controllers/RelatorioController.php
namespace App\Controllers;

use App\Services\ConsultaService;
use App\Views\RelatorioView;

class RelatorioController
{
    private $consultaService;
    private $view;

    public function __construct(ConsultaService $consultaService, RelatorioView $view)
    {
        $this->consultaService = $consultaService;
        $this->view = $view;
    }

    public function gerarRelatorio()
    {
        $stats = $this->consultaService->getStatisticsByMonth();
        $this->view->exibirRelatorio($stats);
    }
}