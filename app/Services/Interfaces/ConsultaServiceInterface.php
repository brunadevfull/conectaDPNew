<?php
// app/Services/Interfaces/ConsultaServiceInterface.php
namespace App\Services\Interfaces;

interface ConsultaServiceInterface
{
    public function readDocumentsFromExcel($filePath);
    public function registerConsulta($username, $documento, $tipoDocumento);
    public function performConsulta($tipo, $documentos);
    public function getStatisticsByMonth();
}