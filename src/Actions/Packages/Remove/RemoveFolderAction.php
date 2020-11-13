<?php

namespace Pipes\Actions\Packages\Remove;

use Illuminate\Filesystem\Filesystem;
use Throwable;

class RemoveFolderAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '_pipes::commands:remove:package'
    ];

    /**
     * $__fileSystem
     * 
     * @var Filesystem
     */
    private $__fileSystem;

    /**
     * __constructor
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param Filesystem $fileSystem
     */
    public function __construct(Filesystem $fileSystem)
    {
        $this->__fileSystem = $fileSystem;
    }

    /**
     * execute
     *
     * Copy the stubs into packages folder
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function execute($cli, $next)
    {
        $package = $cli->argument('name');
        $cli->line("[PIPES] Removing $package package...");

        try {
            // Replaces stub content
            $this->__fileSystem->deleteDirectory(base_path("packages/$package"));

            $cli->info("[PIPES] $package was removed with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
