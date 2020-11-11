<?php

namespace Pipes\Actions\Packages\Create;

use Pipes\Services\ComposerService;
use Throwable;

class UpdateComposer
{
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
        $package = $cli->argument('package');
        $cli->line("[PIPES] Updating composer.json...");

        try {

            // Add the package namespace into composer.json
            $this->composerService->open()
                ->addNamespace("Packages\\$package\\", ("packages/$package/"))
                ->close()
                ->dumpAutoload();

            $cli->info("[PIPES] composer.json updated with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
