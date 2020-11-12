<?php

namespace Pipes\Actions\App\Install;

class CreatePackagesFolderAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '_pipes::commands:install'
    ];

    /**
     * execute
     *
     * Creates the packages folder in the root
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function execute($cli, $next)
    {
        $cli->line(__('[PIPES] Creating packages folder at root...'));

        if (!is_dir(base_path('packages'))) {
            mkdir(base_path('packages'));
        }

        $cli->info(__('[PIPES] Packages folder successfuly created!'));

        return $next($cli);
    }
}
