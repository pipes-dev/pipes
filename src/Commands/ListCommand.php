<?php

namespace Pipes\Commands;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

/**
 * ListCommand
 * 
 * List all pipes resource
 *
 * @author Gustavo Vilas Boas
 * @since 23/11/2020
 */
class ListCommand extends Command
{
    /**
     * Command signature
     *
     */
    public $signature = 'pipes:list {type} {name?} {--package=?} {--filter=}';

    /**
     * Command description
     *
     */
    public $description = 'List all pipes resource';

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
        $this->stream->send("_pipes::commands:list:$type", $this);
    }
}
