<?php

namespace Pipes\Actions\Migrations\Create;

use Illuminate\Support\Facades\Artisan;
use Throwable;

class CreateMigrationAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '_pipes::commands:make:migration'
    ];

    /**
     * execute
     *
     * Run artisan command to migration
     *
     * @author Vinícius Fernando Sampaio da Silva
     * @since 17/11/2020
     */
    public function execute($cli, $next)
    {
        $package = $cli->option('package');
        $name = $cli->argument('name');

        $cli->line("[PIPES] Make migration to $package package...");
        try {
            $type = $cli->option('create') ?
                ['--create'   => $cli->option('create')] :
                ['--table'    => $cli->option('table')];

            Artisan::call('make:migration', array_merge([
                'name'      => $name,
                '--path'   => "packages/$package/Database/Migrations",
            ], $type));

            $cli->info("[PIPES] Migration to $package was created with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
