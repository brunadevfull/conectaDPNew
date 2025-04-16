<?php
// app/Repositories/Interfaces/LoginHistoryRepositoryInterface.php
namespace App\Repositories\Interfaces;

interface LoginHistoryRepositoryInterface
{
    public function registerSuccessfulLogin($username);
    public function registerFailedAttempt($username);
    public function getFailedAttempts($username);
    public function resetFailedAttempts($username);
}