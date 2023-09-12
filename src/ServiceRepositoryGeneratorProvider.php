<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator;

use Illuminate\Support\ServiceProvider;
use Ferdinalaxewall\ServiceRepositoryGenerator\Handlers\GeneratorHandler;
use Ferdinalaxewall\ServiceRepositoryGenerator\Functions\ServiceGenerator;
use Ferdinalaxewall\ServiceRepositoryGenerator\Functions\RepositoryGenerator;
use Ferdinalaxewall\ServiceRepositoryGenerator\Console\Commands\ServiceGeneratorCommand;
use Ferdinalaxewall\ServiceRepositoryGenerator\Console\Commands\RepositoryGeneratorCommand;
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
        $this->app->bind('generator-handler', function (){
            return new GeneratorHandler();
        });

        $this->app->bind('service-generator', function (){
            return new ServiceGenerator();
        });

        $this->app->bind('repository-generator', function (){
            return new RepositoryGenerator();
        });


        $this->dataBinding('Services');
        $this->dataBinding('Repositories');

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
                ServiceRepositoryGeneratorCommand::class,
                ServiceGeneratorCommand::class,
                RepositoryGeneratorCommand::class
            ]);
        }
    }

    /**
     * binding any service or repository classes using recursive method.
     *
     * @param string $directoryName
     * 
     * @return void
     */
    private function dataBinding(string $directoryName): void
    {
        $filesystem = $this->app->make('files');
        $directoryType = explode('/', $directoryName)[0] == 'Services' ? 'Service' : 'Repository';

        if(file_exists(app_path($directoryName))){
            if(count($filesystem->files(app_path($directoryName))) > 0){
                $lastDirectoryName = $this->getLastDirectoryNameFromDirectoryPath($directoryName);
                $currentDirectoryNamespace = $this->getNamespaceOfClassPath($directoryName);
                $this->app->bind("App\\{$currentDirectoryNamespace}\\{$lastDirectoryName}{$directoryType}", "App\\{$currentDirectoryNamespace}\\{$lastDirectoryName}{$directoryType}Imp");
            }
            
            if(count($filesystem->directories(app_path($directoryName))) > 0){
                foreach ($filesystem->directories(app_path($directoryName)) as $directory) {
                    $lastDirectoryName = $this->getLastDirectoryNameFromDirectoryPath($directory);
                    $newDirectoryPath = $directoryName . '/' . $lastDirectoryName;
                    $this->dataBinding($newDirectoryPath);
                }
            }
        }
    }

    /**
     * get namespace of class path.
     *
     * @param string $classPath
     * 
     * @return string
     */
    private function getNamespaceOfClassPath(string $classPath): string
    {
        return str_replace('/', '\\', $classPath);
    }

    /**
     * get last directory name from directory path.
     *
     * @param string $classPath
     * 
     * @return string
     */
    private function getLastDirectoryNameFromDirectoryPath(string $directoryPath): string
    {
        return last(explode('/', $directoryPath));
    }

}
