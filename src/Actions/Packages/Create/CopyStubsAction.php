<?php

namespace Pipes\Actions\Packages\Create;

class CopyStubsAction
{
    /**
     * execute
     *
     * Copy the stubs into packages folder
     *
     * @author Gustavo Vilas Boas
     */
    public function execute($cli, $next)
    {
        $package = $cli->argument('package');
        $cli->info("Creating $package package...");

        return $next($cli);
    }
}
