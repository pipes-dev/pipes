<?php

namespace Pipes\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Exception;

/**
 * TemplateService
 * 
 * Service responsable for template updating
 *
 * @author Gustavo Vilas Boas
 * @since 11/11/2020
 */
class TemplateService
{
    /**
     * __fileSystem
     * 
     * @var FileSystem
     */
    private $__fileSystem;

    /**
     * __construct
     * 
     * @author Gustavo Vilas Boas
     * @since 12/11/2020
     * @param FileSystem $fileSystem
     */
    public function __construct(FileSystem $fileSystem)
    {
        $this->__fileSystem = $fileSystem;
    }

    /**
     * replaceContents
     * 
     * Replace all stub content from a folder
     * 
     * @author Gustavo Vilas Bôas
     * @since 11/11/2020
     * @param string $target
     * @param array $template
     * @return bool
     */
    public function replaceContents(string $target, array $template): bool
    {
        // Get all files from target
        $files = $this->__fileSystem->allFiles($target);

        foreach ($files as $file) {

            // Check if it is a stub file
            if (!Str::endsWith($file, '.stub')) {
                continue;
            }

            // Get file contents and remove the stub
            $content = $this->__fileSystem->get($file);
            $this->__fileSystem->delete($file);

            foreach ($template as $search => $replace) {

                // Replace the stubs with the template
                $content = str_replace($search, $replace, $content);
                $file = str_replace($search, $replace, $file);
            }

            // Saves the new file
            $this->__fileSystem->replace(substr($file, 0, -5), $content);
        }

        return true;
    }
}
