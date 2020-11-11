<?php

namespace Pipes\Services;

/**
 * ComposerService
 * 
 * Service responsable for writing into projects
 * composer.json
 *
 * @author Gustavo Vilas Boas
 * @since 11/11/2020
 */
class ComposerService
{

    /**
     * $content
     *
     * @var arr
     */
    public $content;

    /**
     * open
     *
     * Open composer json file
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function open()
    {
        $this->content = json_decode(file_get_contents(base_path('composer.json')), true);
        return $this;
    }

    /**
     * Add namespace to composer
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function addNamespace(string $namespace, string $path)
    {
        $this->content['autoload']['psr-4'][$namespace] = $path;
        return $this;
    }

    /**
     * removeNamespace
     * 
     * Remove namespace from composer.json
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $namespace
     */
    public function removeNamespace(string $namespace)
    {
        if (isset($this->content['autoload']['psr-4'][$namespace])) {
            unset($this->content['autoload']['psr-4'][$namespace]);
        }
        return $this;
    }

    /**
     * dumpAutoload
     *
     * Dump the autoload file
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function dumpAutoload()
    {
        exec('composer dump-autoload');
        return $this;
    }

    /**
     * close
     * 
     * Close composer json file
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function close()
    {
        $fileContent = json_encode($this->content, JSON_PRETTY_PRINT);
        $fileContent = str_replace('\/', '/', $fileContent);
        file_put_contents(base_path('composer.json'), $fileContent);
        return $this;
    }
}
