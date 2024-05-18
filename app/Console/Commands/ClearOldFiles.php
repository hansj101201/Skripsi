<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearOldFiles extends Command
{
    protected $signature = 'clear:oldfiles';

    protected $description = 'Clears old files from storage directory';

    public function handle()
    {
        $directory = storage_path('app');

        $files = File::glob($directory . '/*');

        foreach ($files as $file) {
            if (File::isFile($file) && time() - File::lastModified($file) >= 172800) { // 172800 seconds = 2 days
                File::delete($file);
            }
        }

        $this->info('Old files have been deleted successfully.');
    }
}
