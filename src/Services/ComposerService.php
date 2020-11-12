<?php

namespace Pipes\Services;

use Illuminate\Filesystem\Filesystem;

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
     * $__content
     *
     * @var arr
     */
    private $__content;

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
    public function __construct(Filesystem $fileSystem)
    {
        $this->__fileSystem = $fileSystem;
    }

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
        $this->__content = json_decode($this->__fileSystem->get(base_path('composer.json')), true);
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
        $this->__content['autoload']['psr-4'][$namespace] = $path;
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
        if (isset($this->__content['autoload']['psr-4'][$namespace])) {
            unset($this->__content['autoload']['psr-4'][$namespace]);
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
        $fileContent = json_encode($this->__content, JSON_PRETTY_PRINT);
        $fileContent = str_replace('\/', '/', $fileContent);
        $this->__fileSystem->replace(base_path('composer.json'), $fileContent);
        return $this;
    }
}
