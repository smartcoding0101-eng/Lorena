<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PDO;

class InstallGardenDatabase extends Command
{
    protected $signature = 'garden:install';

    protected $description = 'Crea la base de datos MySQL configurada y ejecuta las migraciones.';

    public function handle(): int
    {
        if (config('database.default') !== 'mysql') {
            $this->error('Configura DB_CONNECTION=mysql en .env antes de instalar.');

            return self::FAILURE;
        }

        $connection = config('database.connections.mysql');
        $database = $connection['database'];

        if (! is_string($database) || ! preg_match('/\A[A-Za-z0-9_]{1,64}\z/', $database)) {
            $this->error('DB_DATABASE debe ser un nombre MySQL de hasta 64 letras, números o guiones bajos.');

            return self::FAILURE;
        }

        try {
            $server = sprintf('mysql:host=%s;port=%s;charset=utf8mb4', $connection['host'], $connection['port']);
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                new PDO(
                    sprintf('%s;dbname=%s', $server, $database),
                    $connection['username'],
                    $connection['password'],
                    $options,
                );
            } catch (\PDOException $exception) {
                if (($exception->errorInfo[1] ?? null) !== 1049) {
                    throw $exception;
                }

                $pdo = new PDO(
                    $server,
                    $connection['username'],
                    $connection['password'],
                    $options,
                );
                $pdo->exec(sprintf(
                    'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
                    $database,
                ));
            }
        } catch (\PDOException $exception) {
            $this->error('No se pudo acceder a MySQL. Comprueba la conexión y los permisos del usuario para la base configurada.');
            report($exception);

            return self::FAILURE;
        }

        DB::purge('mysql');

        $exitCode = Artisan::call('migrate', ['--force' => true]);
        $this->output->write(Artisan::output());

        if ($exitCode !== self::SUCCESS) {
            $this->error('El acceso a la base se confirmó, pero las migraciones no finalizaron.');

            return $exitCode;
        }

        $this->info(sprintf('Base de datos %s y migraciones listas.', $database));

        return self::SUCCESS;
    }
}
