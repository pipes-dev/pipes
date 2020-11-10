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
            \Pipes\Commands\Actions\Install\CreatePackagesFolderAction::class,
        ],
    ];

    /**
     * Pipes commands
     *
     */
    protected $_commands = [
        \Pipes\Commands\PipesInstallCommand::class,
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
