<?php
// app/Strategies/DocumentValidator/CpfValidator.php
namespace App\Strategies\DocumentValidator;

class CpfValidator implements DocumentValidatorInterface
{
    public function validate($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

        for ($i = 9; $i < 11; $i++) {
            $sum = 0;
            for ($j = 0; $j < $i; $j++) {
                $sum += $cpf[$j] * (($i + 1) - $j);
            }
            $digit = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
            if ($digit != $cpf[$i]) return false;
        }

        return true;
    }
}