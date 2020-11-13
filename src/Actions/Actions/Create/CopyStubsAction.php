<?php

namespace Pipes\Actions\Actions\Create;

use Illuminate\Filesystem\Filesystem;
use Pipes\Services\TemplateService;
use Illuminate\Support\Str;
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
        '_pipes::commands:make:action'
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
        $namespace = Str::beforeLast($cli->argument('name'), '\\');
        $classname = class_basename($cli->argument('name'));
        $folder = str_replace('\\', '/', $namespace);
        $package = $cli->options()['package'];

        $cli->line("[PIPES] Creating $classname action at $package...");

        $destFolder = base_path("packages/$package/Actions/$folder");

        try {

            // Create domain folder
            if (!$this->__fileSystem->isDirectory($destFolder)) {
                $this->__fileSystem->makeDirectory($destFolder);
            }

            // Copy to folder
            $this->__fileSystem->copy(
                $this->__stubsPath . "/action.php.stub",
                "$destFolder/$classname.php.stub"
            );

            // Replaces stub content
            $this->__templateService->replaceContents($destFolder, [
                ':classname:' => $classname,
                ':namespace:' => $namespace,
                ':package:' => $package,
            ]);

            $cli->info("[PIPES] $classname was created with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
