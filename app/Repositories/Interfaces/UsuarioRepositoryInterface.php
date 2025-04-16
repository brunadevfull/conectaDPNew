<?php
// app/Repositories/Interfaces/UsuarioRepositoryInterface.php
namespace App\Repositories\Interfaces;

use App\Models\Usuario;

interface UsuarioRepositoryInterface
{
    public function findById($id): ?Usuario;
    public function findByUsername($username): ?Usuario;
    public function save(Usuario $usuario): bool;
    public function exists($username): bool;
    public function blockUser(Usuario $usuario): bool;
    public function unblockUser(Usuario $usuario): bool;
}