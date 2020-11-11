<?php

namespace Pipes\Services;

use Illuminate\Support\Str;

class ConfigFileService
{

    /**
     * addProvider
     * 
     * Add a provider to the application
     * 
     * @author Gustavo Vilas Boas
     * @param string $provider
     */
    public function addProvider(string $provider)
    {
        // Get config content as array
        $lines = file(base_path('config/app.php'));

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
        file_put_contents(base_path('config/app.php'), join($lines));
    }
}
