<?php
// app/Strategies/DocumentValidator/CnisValidator.php
namespace App\Strategies\DocumentValidator;

class CnisValidator implements DocumentValidatorInterface
{
    public function validate($cnis)
    {
        $cnis = preg_replace('/[^0-9]/', '', $cnis);
        if (strlen($cnis) != 11 || preg_match('/(\d)\1{10}/', $cnis)) return false;

        for ($i = 9; $i < 11; $i++) {
            $sum = 0;
            for ($j = 0; $j < $i; $j++) {
                $sum += $cnis[$j] * (($i + 1) - $j);
            }
            $digit = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
            if ($digit != $cnis[$i]) return false;
        }

        return true;
    }
}