<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class CreateGardenOwner extends Command
{
    protected $signature = 'garden:create-owner';

    protected $description = 'Crea la única cuenta propietaria sin exponer la contraseña.';

    public function handle(): int
    {
        if (User::query()->exists()) {
            $this->error('Ya existe una cuenta. No se crea un registro adicional.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Nombre para mostrar'));
        $email = mb_strtolower(trim((string) $this->ask('Correo de acceso')));
        $password = (string) $this->secret('Contraseña (mínimo 12 caracteres)');
        $confirmation = (string) $this->secret('Repite la contraseña');

        try {
            Validator::make(
                compact('name', 'email', 'password') + ['password_confirmation' => $confirmation],
                [
                    'name' => ['required', 'string', 'max:120'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                    'password' => ['required', 'string', Password::min(12), 'confirmed'],
                ],
            )->validate();
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->error($message);
                }
            }

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('La cuenta propietaria se creó. Inicia sesión desde el acceso "Mi espacio".');

        return self::SUCCESS;
    }
}
