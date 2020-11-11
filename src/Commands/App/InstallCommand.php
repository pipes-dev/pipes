<?php

namespace Pipes\Commands\App;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

/**
 * InstallCommand
 * 
 * Install pipes into a Laravel application
 *
 * @author Gustavo Vilas Boas
 * @since 11/11/2020
 */
class InstallCommand extends Command
{
    /**
     * Command signature
     *
     */
    public $signature = 'pipes:install';

    /**
     * Command description
     *
     */
    public $description = 'Install pipes into a new laravel project';

    /**
     * $stream
     *
     * @var Stream
     */
    private $stream;

    /**
     * __construct
     *
     * @author Gustavo Vilas Boas
     * @param Stream $stream Stream instance
     */
    public function __construct(Stream $stream)
    {
        parent::__construct();
        $this->stream = $stream;
    }

    /**
     * Handle command execution
     *
     */
    public function handle()
    {
        $this->stream->send('_pipes::commands:install', $this);
    }
}
