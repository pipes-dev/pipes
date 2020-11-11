<?php

namespace Pipes;

use Illuminate\Pipeline\Pipeline;
use Pipes\Support\ServiceProvider;

class PipesServiceProvider extends ServiceProvider
{
    /**
     * Library actions
     *
     */
    protected $_actions = [
        '_pipes::commands:install' => [
            \Pipes\Actions\App\Install\CreatePackagesFolderAction::class,
        ],
        '_pipes::commands:package:create' => [
            \Pipes\Actions\Packages\Create\CopyStubsAction::class,
            \Pipes\Actions\Packages\Create\UpdateComposer::class,
            \Pipes\Actions\Packages\Create\UpdateConfigFile::class,
        ]
    ];

    /**
     * Pipes commands
     *
     */
    protected $_commands = [
        \Pipes\Commands\App\InstallCommand::class,
        \Pipes\Commands\PackageCommand::class,
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
