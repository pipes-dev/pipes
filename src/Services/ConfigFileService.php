<?php

namespace Pipes\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * ConfigFileService
 * 
 * Service responsable for writing into config/app.php
 *
 * @author Gustavo Vilas Boas
 * @since 11/11/2020
 */
class ConfigFileService
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
    public function __construct(Filesystem $fileSystem)
    {
        $this->__fileSystem = $fileSystem;
    }

    /**
     * removeProvider
     * 
     * Remove a provider from config
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $provider
     */
    public function removeProvider(string $provider)
    {
        $provider = "        $provider,\n";

        // Get config content as array
        $lines = $this->__fileSystem->getLines(base_path('config/app.php'));

        // Run trough every line
        foreach ($lines as $number => $line) {

            // Check if it is providers array key
            if (Str::contains($line, $provider)) {
                unset($lines[$number]);
            }
        }

        // Persist the file
        $this->__fileSystem->replace(base_path('config/app.php'), join($lines));
    }

    /**
     * addProvider
     * 
     * Add a provider to the application
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $provider
     */
    public function addProvider(string $provider)
    {
        // Remove the provider
        $this->removeProvider($provider);

        // Get config content as array
        $lines = $this->__fileSystem->getLines(base_path('config/app.php'));

        // Initialize control variables
        $hasPassedToProviders = false;
        $closeLineNumber = 0;

        // Run trough every line
        foreach ($lines as $number => $line) {

            // Check if it is providers array key
            if (Str::contains($line, "'providers' => ")) {
                $hasPassedToProviders = true;
            }

            // Updates the closing providers array line number
            if (Str::contains($line, "]") && $hasPassedToProviders) {
                $closeLineNumber = $number;
                break;
            }
        }

        // Add the providers to lines array
        array_splice($lines, $closeLineNumber, 0, [
            "        $provider,\n"
        ]);

        // Persist the file
        $this->__fileSystem->replace(base_path('config/app.php'), join($lines));
    }
}
