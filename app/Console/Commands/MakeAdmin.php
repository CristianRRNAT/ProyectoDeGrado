<?php
namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;
class MakeAdmin extends Command
{
    protected $signature='app:make-admin {email : Correo del usuario registrado}';
    protected $description='Concede permisos de administrador a un usuario existente';
    public function handle(): int
    {
        $user=User::where('email',$this->argument('email'))->first();
        if(!$user){$this->error('No existe un usuario registrado con ese correo.');return self::FAILURE;}
        $user->update(['is_admin'=>true,'is_active'=>true]);
        $this->info("{$user->name} ahora tiene acceso al panel administrativo.");
        return self::SUCCESS;
    }
}
