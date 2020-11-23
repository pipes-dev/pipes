<?php

namespace Pipes\Actions\Actions\Show;

use Pipes\Stream\Facades\Stream;
use Illuminate\Support\Str;

class ListActionsAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '_pipes::commands:list:actions'
    ];

    /**
     * execute
     *
     * List all registered actions
     *
     * @author Gustavo Vilas Boas
     * @since 23/11/2020
     */
    public function execute($cli, $next)
    {
        $filter = $cli->option('filter') ?? '';

        $triggers = Stream::getTriggers();

        foreach ($triggers as $trigger) {
            if (!empty($filter) && !Str::contains($trigger, $filter)) {
                continue;
            }

            $cli->info("$trigger");

            $actions = Stream::getActions($trigger);

            foreach ($actions as $action) {
                $cli->line("$action::class");
            }
            $cli->newLine();
        }

        return $next($cli);
    }
}
