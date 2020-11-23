<?php

namespace Pipes;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Pipeline\Pipeline;
use Pipes\Support\ServiceProvider;

class PipesServiceProvider extends ServiceProvider
{
    /**
     * Library actions
     *
     */
    protected $_actions = [
        // Install pipes in the laravel application
        \Pipes\Actions\App\Install\CreatePackagesFolderAction::class,
        \Pipes\Actions\App\Install\UpdateComposerAction::class,

        // Create package actions
        \Pipes\Actions\Packages\Create\UpdateConfigFileAction::class,
        \Pipes\Actions\Packages\Create\CopyStubsAction::class,

        // Create package actions
        \Pipes\Actions\Packages\Migration\MigrationAction::class,

        // Remove package actions
        \Pipes\Actions\Packages\Remove\UpdateConfigFileAction::class,
        \Pipes\Actions\Packages\Remove\RemoveFolderAction::class,

        // Make model actions
        \Pipes\Actions\Models\Create\CopyStubsAction::class,

        // Make aciton actions
        \Pipes\Actions\Actions\Create\CopyStubsAction::class,
    ];

    /**
     * Pipes commands
     *
     */
    protected $_commands = [
        \Pipes\Commands\InstallCommand::class,
        \Pipes\Commands\RemoveCommand::class,
        \Pipes\Commands\MakeCommand::class,
    ];

    /**
     * boot
     *
     * Initialize the library
     *
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/pipes.php' => config_path('pipes.php'),
            ], 'config');

            $this->commands($this->_commands);
        }

        // Add get lines do file system macro
        Filesystem::macro('getLines', function (string $path) {
            return file($path);
        });

        parent::boot();
    }

    /**
     * register
     *
     * Register library
     *
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pipes.php', 'pipes');

        // Create stream singleton
        $this->app->singleton('Pipes\\Stream\\Stream', function () {
            return new \Pipes\Stream\Stream(resolve(Pipeline::class));
        });
    }
}
