<?php

namespace Pipes\Commands;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

/**
 * PackageCommand
 * 
 * Interact with packages
 *
 * @author Gustavo Vilas Boas
 * @since 11/11/2020
 */
class PackageCommand extends Command
{
    /**
     * Command signature
     *
     */
    public $signature = 'pipes:package {action} {package}';

    /**
     * Command description
     *
     */
    public $description = 'Using pipes packages system';

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
        $this->stream->send('_pipes::commands:package:' . $this->argument('action'), $this);
    }
}
