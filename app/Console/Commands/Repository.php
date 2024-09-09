<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Repository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repository by Gohari ;)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument("name");
        $this->generateRepository($name);
        $this->generateInterface($name);
        $this->generateRequest($name);
        $this->generateResource($name);
        $this->generateController($name);
        $this->info("Repository {$name} generated successfully.");
    }

    protected function generateRepository($name)
    {
        $repositoryPath = app_path("Repositories/MySQL/{$name}Repository/{$name}Repository.php");
        $template = File::get(base_path('stubs/repository.stub'));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($repositoryPath), 0755, true, true);
        File::put($repositoryPath, $template);
    }

    protected function generateInterface($name)
    {
        $interfacePath = app_path("Repositories/MySQL/{$name}Repository/Interface{$name}Repository.php");
        $template = File::get(base_path('stubs/repository_interface.stub'));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($interfacePath), 0755, true, true);
        File::put($interfacePath, $template);
    }

    protected function generateRequest($name)
    {
        $folder = strtolower($name);
        $interfacePath = app_path("Http/Requests/{$folder}/{$name}Request.php");
        $template = File::get(base_path('stubs/request_custom.stub'));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($interfacePath), 0755, true, true);
        File::put($interfacePath, $template);
    }

    protected function generateResource($name)
    {
        $folder = strtolower($name);
        $interfacePath = app_path("Http/Resources/{$folder}/{$name}Resource.php");
        $template = File::get(base_path('stubs/resource_custom.stub'));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($interfacePath), 0755, true, true);
        File::put($interfacePath, $template);
    }

    protected function generateController($name)
    {
        $interfacePath = app_path("Http/Controllers/{$name}Controller.php");
        $template = File::get(base_path("stubs/controller_custom.stub"));
        $template = str_replace("{{className}}", $name, $template);
        File::makeDirectory(dirname($interfacePath), 0755, true, true);
        File::put($interfacePath, $template);
    }
}
