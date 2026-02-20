<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeApi extends Command
{
    /**
     * The name and signature of the console command.
     * {type} : controller or request
     * {name} : Name of the class
     * {--ver=V1} : API version (Default V1)
     */
    protected $signature = 'make:api {type} {name} {--ver=V1}';

    protected $description = 'Generate versioned API components (Controller/Request)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = strtolower($this->argument('type'));
        $name = Str::studly($this->argument('name'));
        $version = strtoupper($this->option('ver'));

        return match ($type){
            'controller'    => $this->createController($name, $version),
            'request'       => $this->createRequest($name, $version),
            default         => $this->handleInvalidType(),
        };
    }

    private function createController(string $name, string $version): int
    {
        $path = "Api/{$version}/{$name}";

        Artisan::call('make:controller', ['name' => $path]);

        $this->info("Controller [app/Http/Controllers/{$path}.php] created successfully.");
        return self::SUCCESS;
    }

    private function createRequest(string $name, string $version): int
    {
        $path = "Api/{$version}/{$name}";
        
        Artisan::call('make:request', ['name' => $path]);

        $this->info("Request [app/Http/Requests/{$path}.php] created successfully.");
        return self::SUCCESS;
    }

    private function handleInvalidType(): int
    {
        $this->error('Invalid type! Available types: controller, request');
        return self::FAILURE;
    }
}
