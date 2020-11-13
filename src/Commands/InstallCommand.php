<?php

namespace Pipes\Commands;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

/**
 * InstallCommand
 * 
 * Install a pipes resource
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
    public $signature = 'pipes:install {type} {name?} {--package=?}';

    /**
     * Command description
     *
     */
    public $description = 'Install a pipes resource';

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
        $type = $this->argument('type');
        $this->stream->send("_pipes::commands:install:$type", $this);
    }
}
