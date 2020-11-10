<?php

namespace Pipes;

use Illuminate\Support\ServiceProvider;
use Pipes\Commands\PipesCommand;

class PipesServiceProvider extends ServiceProvider
{
    /**
     * Pipes commands
     *
     */
    protected $_commands = [
        PipesCommand::class
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
    }
}
