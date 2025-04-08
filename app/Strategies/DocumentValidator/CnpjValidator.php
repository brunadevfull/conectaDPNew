<?php
// app/Strategies/DocumentValidator/CnpjValidator.php
namespace App\Strategies\DocumentValidator;

class CnpjValidator implements DocumentValidatorInterface
{
    public function validate($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) return false;

        $soma = 0;
        for ($i = 0, $pos = 5; $i < 12; $i++) {
            $soma += $cnpj[$i] * $pos--;
            if ($pos < 2) $pos = 9;
        }
        $digito1 = $soma % 11 < 2 ? 0 : 11 - $soma % 11;

        $soma = 0;
        for ($i = 0, $pos = 6; $i < 13; $i++) {
            $soma += $cnpj[$i] * $pos--;
            if ($pos < 2) $pos = 9;
        }
        $digito2 = $soma % 11 < 2 ? 0 : 11 - $soma % 11;

        return $cnpj[12] == $digito1 && $cnpj[13] == $digito2;
    }
}