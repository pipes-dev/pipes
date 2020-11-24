<?php

namespace Pipes\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Pipes\Stream\Facades\Stream;

trait HasActions
{
    /**
     * $_actions
     *
     * @var array
     */
    protected $_actions = [];

    /**
     * __scanActionsFolder
     *
     * Scans a directory to find actions inside it
     *
     * @author Gustavo Vilas Boas
     * @since 23/11/2020
     */
    private function __scanActionsFolder(string $namespace, string $folder)
    {
        // Get all files from actions folder
        $files = File::allFiles($folder);

        // All discovered actions
        $actions = [];

        // Parse and add full class namespace to actions array
        foreach ($files as $file) {
            $classname = Str::replaceLast('.php', '', $file->getRelativePathname());
            $actions[] = str_replace('/', '\\', $namespace . $classname);
        }

        // Return the parsed actions
        return $actions;
    }

    /**
     * __bootActions
     *
     * Initialize the actions
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __bootActions()
    {
        $actions = collect($this->_actions)->flatMap(function ($folder, $key) {
            return $this->__scanActionsFolder($key, $folder);
        })->flatten();

        foreach ($actions as $action) {
            foreach ($action::$triggers as $event) {
                Stream::attach($event, $action);
            }
        }
    }
}
