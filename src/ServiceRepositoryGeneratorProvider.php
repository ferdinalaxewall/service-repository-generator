<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator;

use Illuminate\Support\ServiceProvider;
use Ferdinalaxewall\ServiceRepositoryGenerator\Handlers\GeneratorHandler;
use Ferdinalaxewall\ServiceRepositoryGenerator\Console\Commands\ServiceRepositoryGeneratorCommand;

class ServiceRepositoryGeneratorProvider extends ServiceProvider
{
    /**
     * register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('service-repository-generator', function (){
            return new GeneratorHandler();
        });

        $filesystem = $this->app->make('files');

        if(file_exists(app_path('Services'))){
            foreach($filesystem->directories(app_path('Services')) as $directory){
                $directoryName = last(explode('/', $directory));
                $this->app->bind("App\\Services\\{$directoryName}\\{$directoryName}Service", "App\\Services\\{$directoryName}\\{$directoryName}ServiceImp");
            }
        }

        if(file_exists(app_path('Repositories'))){
            foreach($filesystem->directories(app_path('Repositories')) as $directory){
                $directoryName = last(explode('/', $directory));
                $this->app->bind("App\\Repositories\\{$directoryName}\\{$directoryName}Repository", "App\\Repositories\\{$directoryName}\\{$directoryName}RepositoryImp");
            }
        }
    }

    /**
     * bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if($this->app->runningInConsole()) {
            $this->commands([
                ServiceRepositoryGeneratorCommand::class
            ]);
        }
    }

}
