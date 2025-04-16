<?php
// app/Repositories/Interfaces/ConsultaRepositoryInterface.php
namespace App\Repositories\Interfaces;

interface ConsultaRepositoryInterface
{
    public function registerConsulta($username, $documento, $tipoDocumento);
    public function getFailedLoginsByMonth();
    public function getConsultasByMonth();
}