<?php
// app/Factories/ControllerFactory.php
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
    
    // app/Factories/ControllerFactory.php
    public static function createConsultaController()
    {
        $usuarioRepository = new UsuarioRepository();
        var_dump($usuarioRepository); // Verificar se o objeto foi criado corretamente
        
        $loginHistoryRepository = new LoginHistoryRepository();
        var_dump($loginHistoryRepository); // Verificar se o objeto foi criado corretamente
        
        $authService = new AuthService($usuarioRepository, $loginHistoryRepository);
        var_dump($authService); // Verificar se o service foi criado corretamente
        
        $consultaService = new ConsultaService(new ConsultaRepository());
        $view = new ConsultaView();
        
        return new ConsultaController($authService, $consultaService, $view);
    }
}