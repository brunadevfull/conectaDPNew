<?php
// app/Factories/ControllerFactory.php - Versão corrigida

namespace App\Factories;

use App\Controllers\CadastroController;
use App\Controllers\ConsultaController;
use App\Controllers\RelatorioController;
use App\Repositories\UsuarioRepository;
use App\Repositories\LoginHistoryRepository;
use App\Repositories\ConsultaRepository;
use App\Services\AuthService;
use App\Services\ConsultaService;
use App\Services\CadastroService;
use App\Views\CadastroView;
use App\Views\ConsultaView;
use App\Views\RelatorioView;

class ControllerFactory
{
    public static function createCadastroController()
    {
        $usuarioRepository = new UsuarioRepository();
        $cadastroService = new CadastroService($usuarioRepository);
        $view = new CadastroView();
        
        return new CadastroController($cadastroService, $view);
    }
    
    public static function createConsultaController()
    {
        $usuarioRepository = new UsuarioRepository();
        $loginHistoryRepository = new LoginHistoryRepository();
        $authService = new AuthService($usuarioRepository, $loginHistoryRepository);
        $consultaService = new ConsultaService(new ConsultaRepository());
        $view = new ConsultaView();
        
        return new ConsultaController($authService, $consultaService, $view);
    }
    
    public static function createRelatorioController()
    {
        $consultaRepository = new ConsultaRepository();
        $consultaService = new ConsultaService($consultaRepository);
        $view = new RelatorioView();
        
        return new RelatorioController($consultaService, $view);
    }
}