<?php

namespace Pipes\Actions\App\Install;

use Pipes\Services\ComposerService;
use Throwable;

class UpdateComposerAction
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
     * $composerService
     * 
     * @var ComposerService
     */
    private $composerService;

    /**
     * __constructor
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __construct(ComposerService $composerService)
    {
        $this->composerService = $composerService;
    }

    /**
     * execute
     * 
     * Update composer.json file with new content
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function execute($cli, $next)
    {
        $cli->line("[PIPES] Updating composer.json...");

        try {

            // Add the package namespace into composer.json
            $this->composerService->open()
                ->addNamespace("Packages\\", ("packages/"))
                ->close()
                ->dumpAutoload();

            $cli->info("[PIPES] composer.json updated with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
