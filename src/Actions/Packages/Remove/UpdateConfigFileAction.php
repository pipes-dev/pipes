<?php

namespace Pipes\Actions\Packages\Remove;

use Pipes\Services\ConfigFileService;
use Throwable;

class UpdateConfigFileAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '_pipes::commands:package:remove'
    ];

    /**
     * $configFileService
     * 
     * @var ConfigFileService
     */
    private $configFileService;

    /**
     * __constructor
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __construct(ConfigFileService $configFileService)
    {
        $this->configFileService = $configFileService;
    }

    /**
     * execute
     * 
     * Update config/app.php file with new content
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function execute($cli, $next)
    {
        $package = $cli->argument('package');
        $cli->line("[PIPES] Updating config/app.php...");

        try {

            // Add provider to config/app.php
            $provider = sprintf("Packages\%s\%sServiceProvider::class", $package, $package);
            $this->configFileService->removeProvider($provider);

            $cli->info("[PIPES] config/app.php updated with success");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
