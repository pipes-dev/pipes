<?php

namespace Pipes\Services;

use Illuminate\Support\Str;
use Exception;

class FileSystemService
{
    /**
     * getFiles
     * 
     * Get all files from target recursivelly
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $target
     * @return array $result
     */
    public function getFiles(string $target): array
    {
        // Get all files and folders from the target
        $tree = glob(rtrim($target, '/') . '/*');
        if (!is_array($tree)) {
            return [];
        }

        $result = [];
        foreach ($tree as $file) {

            // If it is a dir, call this function recursivelly
            if (is_dir($file)) {
                $result = [...$result, ...$this->getFiles($file)];
                continue;
            }

            // If it is a file, add to result array
            $result[] = $file;
        }

        // Returns all founded files
        return $result;
    }

    /**
     * replaceStubsContent
     * 
     * Replace all stub content from a folder
     * 
     * @author Gustavo Vilas Bôas
     * @since 11/11/2020
     * @param string $target
     * @param array $template
     * @return bool
     */
    public function replaceStubsContent(string $target, array $template): bool
    {
        // Get all files from target
        $files = $this->getFiles($target);

        foreach ($files as $file) {

            // Check if it is a stub file
            if (!Str::endsWith($file, '.stub')) {
                continue;
            }

            // Get file contents and remove the stub
            $content = file_get_contents($file);
            unlink($file);

            foreach ($template as $search => $replace) {

                // Replace the stubs with the template
                $content = str_replace($search, $replace, $content);
                $file = str_replace($search, $replace, $file);
            }

            // Saves the new file
            file_put_contents(substr($file, 0, -5), $content);
        }

        return true;
    }

    /**
     * mirror
     * 
     * Copy and entire dir into another
     * 
     * @author Gustavo Vilas Bôas
     * @since 11/11/2020
     * @param string $from
     * @param string $to
     * @throws Exception
     */
    public function mirror(string $from, string $to)
    {
        // Check if the dir already exists
        if (is_dir($to)) {
            throw new Exception(__("Folder $to already exists!"));
        }

        // Copy the target into destination
        return exec("`cp -r $from $to`");
    }
}
