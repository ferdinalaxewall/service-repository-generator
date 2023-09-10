<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Console\Commands;

use Illuminate\Console\Command;
use Ferdinalaxewall\ServiceRepositoryGenerator\Facades\ServiceRepositoryGenerator;

class ServiceRepositoryGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service-repository {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for Generate Service Repository by Model Name';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            if(file_exists(app_path('Models/' . $this->argument('model') . '.php'))){
                ServiceRepositoryGenerator::generateFromModel($this->argument('model'), 'service,repository');
            }else{
                $this->error("Oops: \"{$this->argument('model')}\" model not found!");
                if($this->confirm("Do you want to continue with create a \"{$this->argument('model')}\" model?", true)){
                    $this->call("make:model", [
                        'name' => $this->argument('model')
                    ]);
                    ServiceRepositoryGenerator::generateFromModel($this->argument('model'), 'service,repository');
                }
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
