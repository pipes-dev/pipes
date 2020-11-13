<?php

namespace Pipes\Actions\Models\Create;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
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
        '_pipes::commands:make:model'
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
        $package = $cli->options()['package'];
        $model = $cli->argument('name');
        $folder = Str::plural($model);
        $trigger = Str::snake($package) . '::' . Str::snake($folder);

        $cli->line("[PIPES] Creating $model model as $package...");

        $domainPath = base_path("packages/$package/Domains/$folder");

        try {

            // Create domain folder
            if (!$this->__fileSystem->isDirectory($domainPath)) {
                $this->__fileSystem->makeDirectory($domainPath);
            }

            // Copy to folder
            $this->__fileSystem->copy(
                $this->__stubsPath . "/model.php.stub",
                "$domainPath/$model.php.stub"
            );

            // Replaces stub content
            $this->__templateService->replaceContents($domainPath, [
                ':trigger:' => $trigger,
                ':package:' => $package,
                ':folder:' => $folder,
                ':model:' => $model,
            ]);

            $cli->info("[PIPES] $model was created with success!");
        } catch (Throwable $e) {
            $cli->error($e->getMessage());
        }

        return $next($cli);
    }
}
