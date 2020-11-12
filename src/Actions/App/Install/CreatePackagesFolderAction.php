<?php

namespace Pipes\Actions\App\Install;

use Illuminate\Filesystem\Filesystem;

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
     * $__fileSystem
     * 
     * @var FileSysyem
     */
    private $__fileSystem;

    /**
     * __constructor
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->__fileSystem = $filesystem;
    }

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

        $basePath = base_path('packages');

        if (!$this->__fileSystem->isDirectory($basePath)) {
            $this->__fileSystem->makeDirectory($basePath);
        }

        $cli->info(__('[PIPES] Packages folder successfuly created!'));

        return $next($cli);
    }
}
