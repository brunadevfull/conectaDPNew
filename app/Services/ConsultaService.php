<?php
// app/Services/ConsultaService.php
namespace App\Services;

use App\Services\Interfaces\ConsultaServiceInterface;
use App\Repositories\Interfaces\ConsultaRepositoryInterface;
use App\Adapters\ApiConectaGovAdapter;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConsultaService implements ConsultaServiceInterface
{
    private $consultaRepository;

    public function __construct(ConsultaRepositoryInterface $consultaRepository)
    {
        $this->consultaRepository = $consultaRepository;
    }

    
    public function readDocumentsFromExcel($filePath)
    {
        $documentArray = [];

        try {
            if (!file_exists($filePath)) {
                throw new \Exception('Arquivo não encontrado: ' . $filePath);
            }

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellValue = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();

                if (!empty($cellValue)) {
                    $documentoLimpo = preg_replace('/[^0-9]/', '', $cellValue);
                    $documentArray[] = $documentoLimpo;
                }
            }
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            throw new \Exception('Erro ao ler a planilha: ' . $e->getMessage());
        }

        return $documentArray;
    }


    public function registerConsulta($username, $documento, $tipoDocumento)
    {
        return $this->consultaRepository->registerConsulta($username, $documento, $tipoDocumento);
    }

 
public function performConsulta($tipo, $documentos)
{
    try {
        $adapter = new ApiConectaGovAdapter($tipo);
        
        switch ($tipo) {
            case 'CPF':
                return $adapter->consultaCpf($documentos);
            case 'CNPJ':
                // Se tivermos múltiplos CNPJs, trate um por um
                if (count($documentos) > 1) {
                    $resultados = [];
                    foreach ($documentos as $documento) {
                        if (!empty($documento)) {
                            $resultados[] = $adapter->consultaCnpj($documento);
                        }
                    }
                    return $resultados;
                } else {
                    return $adapter->consultaCnpj($documentos[0]);
                }
            case 'CNIS':
                // Se tivermos múltiplos CPFs para CNIS, trate um por um
                if (count($documentos) > 1) {
                    $resultados = [];
                    foreach ($documentos as $documento) {
                        if (!empty($documento)) {
                            $resultados[] = $adapter->consultaCnis($documento);
                        }
                    }
                    return $resultados;
                } else {
                    return $adapter->consultaCnis($documentos[0]);
                }
            default:
                throw new \InvalidArgumentException("Tipo de consulta inválido: $tipo");
        }
    } catch (\Exception $e) {
        error_log("Erro ao realizar consulta: " . $e->getMessage());
        return ['error' => $e->getMessage()];
    }
}

    public function getStatisticsByMonth()
    {
        $loginData = $this->consultaRepository->getFailedLoginsByMonth();
        $consultaData = $this->consultaRepository->getConsultasByMonth();

        return [
            'login' => $this->formatMonthData($loginData),
            'cpfConsultas' => $this->formatConsultaData($consultaData, 'CPF'),
            'cnpjConsultas' => $this->formatConsultaData($consultaData, 'CNPJ'),
            'cnisConsultas' => $this->formatConsultaData($consultaData, 'CNIS')
        ];
    }

    private function formatMonthData($data)
    {
        $monthNames = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        $formattedData = [];
        foreach ($monthNames as $month => $monthName) {
            $formattedData[$monthName] = 0;
        }

        foreach ($data as $item) {
            $formattedData[$monthNames[$item['mes']]] = (int)$item['total'];
        }

        return $formattedData;
    }

    private function formatConsultaData($data, $tipo)
    {
        $monthNames = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        $formattedData = [];
        foreach ($monthNames as $month => $monthName) {
            $formattedData[$monthName] = 0;
        }

        foreach ($data as $item) {
            if ($item['tipo_documento'] === $tipo) {
                $formattedData[$monthNames[$item['mes']]] = (int)$item['total'];
            }
        }

        return $formattedData;
    }
}