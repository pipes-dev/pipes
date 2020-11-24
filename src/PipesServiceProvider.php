<?php

namespace Pipes;

use Illuminate\Filesystem\Filesystem;
use Pipes\Support\ServiceProvider;
use Illuminate\Pipeline\Pipeline;

class PipesServiceProvider extends ServiceProvider
{

    /**
     * $_actionsFolder
     * 
     * Location of package actions
     * 
     * @var array
     */
    protected $_actions = [
        'Pipes\\Eloquent\\Actions\\' => __DIR__ . '/Eloquent/Actions',
        'Pipes\\Actions\\' => __DIR__ . '/Actions',
    ];

    /**
     * Pipes commands
     *
     */
    protected $_commands = [
        \Pipes\Commands\InstallCommand::class,
        \Pipes\Commands\RemoveCommand::class,
        \Pipes\Commands\MakeCommand::class,
        \Pipes\Commands\ListCommand::class,
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
