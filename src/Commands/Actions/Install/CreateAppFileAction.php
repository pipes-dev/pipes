<?php

namespace Pipes\Commands\Actions\Install;

class CreateAppFileAction
{
    /**
     * execute
     * 
     * Creates the app file in bootstrap folder
     * 
     * @author Gustavo Vilas Boas
     */
    public function execute($args, $next)
    {
        return $next($args);
    }
}
