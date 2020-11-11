<?php

namespace Pipes\Actions\Packages\Create;

use Pipes\Services\FileSystemService;
use Throwable;

class CopyStubsAction
{
    /**
     * $stubsPath
     * 
     * @var string
     */
    private $stubsPath;

    /**
     * $fileSystemService
     * 
     * @var FileSystemService
     */
    private $fileSystemService;

    /**
     * __constructor
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __construct(FileSystemService $fileSystemService)
    {
        $this->fileSystemService = $fileSystemService;
        $this->stubsPath = config('pipes.stubs.path');
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
            $this->fileSystemService->mirror(
                $this->stubsPath . "/package",
                base_path("packages/$package")

            );

            // Replaces stub content
            $this->fileSystemService->replaceStubsContent(base_path("packages/$package"), [
                ':package:' => $package
            ]);

            $cli->info("[PIPES] $package was created with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
