<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repository and request , response , controller by Gohari ;)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument("name");
        $this->generateRepository($name);
        $this->info("Repository {$name} generated successfully.");
    }

    protected function generateRepository($name)
    {
        $repositoryPath = app_path("Services/{$name}Service.php");
        $template = File::get(base_path('stubs/service.stub'));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($repositoryPath), 0755, true, true);
        File::put($repositoryPath, $template);
    }

}
