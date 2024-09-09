<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Enum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enum builder by Gohari ;)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument("name");
        $this->generateEnum($name);
        $this->info(" Enum {$name} generated successfully.");
    }

    protected function generateEnum($name)
    {
        $path = app_path("Enums/{$name}.php");
        $template = File::get(base_path('stubs/enum_template.stub'));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($path), 0755, true, true);
        File::put($path, $template);
    }
}
