<?php

namespace Pipes\Commands\Packages;

use Illuminate\Console\Command;
use Pipes\Stream\Stream;

class CreatePackageCommand extends Command
{
    /**
     * Command signature
     *
     */
    public $signature = 'pipes:package-create {package}';

    /**
     * Command description
     *
     */
    public $description = 'Creates a new pipes package';

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
        $this->stream->send('_pipes::commands:package:create', $this);
    }
}
