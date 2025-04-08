<?php
namespace App\Factories;

use App\Strategies\DocumentValidator\CpfValidator;
use App\Strategies\DocumentValidator\CnpjValidator;
use App\Strategies\DocumentValidator\CnisValidator;
use App\Strategies\DocumentValidator\DocumentValidatorInterface;

class DocumentValidatorFactory
{
    public static function create($type): DocumentValidatorInterface
    {
        switch ($type) {
            case 'CPF':
                return new CpfValidator();
            case 'CNPJ':
                return new CnpjValidator();
            case 'CNIS':
                return new CnisValidator();
            default:
                throw new \InvalidArgumentException("Invalid document type: $type");
        }
    }
}