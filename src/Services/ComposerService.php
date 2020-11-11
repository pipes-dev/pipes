<?php

namespace Pipes\Services;

class ComposerService
{

    /**
     * Composer json content
     *
     */
    public $content;

    /**
     * Open composer json file
     *
     */
    public function open()
    {
        $this->content = json_decode(file_get_contents(base_path('composer.json')), true);
        return $this;
    }

    /**
     * Add namespace to composer
     *
     */
    public function addNamespace(string $namespace, string $path)
    {
        $this->content['autoload']['psr-4'][$namespace] = $path;
        return $this;
    }

    /**
     * Add file to composer
     *
     */
    public function addFile(string $file)
    {
        $files = $this->content['autoload']['files'];
        $files[] = $file;
        $this->content['autoload']['files'] = array_unique($files);
        return $this;
    }

    /**
     * Dump the autoload file
     *
     */
    public function dumpAutoload()
    {
        exec('composer dump-autoload');
        return $this;
    }

    /**
     * Close composer json file
     *
     */
    public function close()
    {
        $fileContent = json_encode($this->content, JSON_PRETTY_PRINT);
        $fileContent = str_replace('\/', '/', $fileContent);
        file_put_contents(base_path('composer.json'), $fileContent);
        return $this;
    }
}
