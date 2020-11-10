<?php

namespace Pipes\Commands;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

class PipesInstallCommand extends Command
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
        $this->stream->send('_pipes::commands:install');
    }
}
