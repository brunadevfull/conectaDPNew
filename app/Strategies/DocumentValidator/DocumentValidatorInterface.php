<?php
// app/Strategies/DocumentValidator/DocumentValidatorInterface.php
namespace App\Strategies\DocumentValidator;

interface DocumentValidatorInterface
{
    public function validate($document);
}