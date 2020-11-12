<?php

namespace Pipes\Actions\Packages\Create;

use Illuminate\Filesystem\Filesystem;
use Pipes\Services\TemplateService;
use Throwable;

class CopyStubsAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '_pipes::commands:package:create'
    ];

    /**
     * $fileSystemService
     * 
     * @var FileSystemService
     */
    private $__fileSystem;

    /**
     * $__templateService
     * 
     * @var TemplateService
     */
    private $__templateService;

    /**
     * $__stubsPath
     * 
     * @var string
     */
    private $__stubsPath;

    /**
     * __constructor
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __construct(
        Filesystem $fileSystem,
        TemplateService $templateService
    ) {
        $this->__stubsPath = config('pipes.stubs.path');
        $this->__templateService = $templateService;
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
        $package = $cli->argument('package');
        $cli->line("[PIPES] Creating $package package...");

        try {

            // Copy to folder
            $this->__fileSystem->copyDirectory(
                $this->__stubsPath . "/package",
                base_path("packages/$package")

            );

            // Replaces stub content
            $this->__templateService->replaceContents(base_path("packages/$package"), [
                ':package:' => $package
            ]);

            $cli->info("[PIPES] $package was created with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
