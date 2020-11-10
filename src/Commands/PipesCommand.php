<?php

namespace Pipes\Commands;

use Illuminate\Console\Command;

class PipesCommand extends Command
{
    /**
     * Command signature
     *
     */
    public $signature = 'pipes';

    /**
     * Command description
     *
     */
    public $description = 'My command';

    /**
     * Handle command execution
     *
     */
    public function handle()
    {
        $this->comment('All done');
    }
}
