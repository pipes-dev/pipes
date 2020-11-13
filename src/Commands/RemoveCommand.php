<?php

namespace Pipes\Commands;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

/**
 * RemoveCommand
 * 
 * Remove a pipes resource
 *
 * @author Gustavo Vilas Boas
 * @since 11/11/2020
 */
class RemoveCommand extends Command
{
    /**
     * Command signature
     *
     */
    public $signature = 'pipes:remove {type} {name} {--package=?}';

    /**
     * Command description
     *
     */
    public $description = 'Remove a pipes resource';

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
        $this->stream->send("_pipes::commands:remove:$type", $this);
    }
}
