<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Console\Commands;

use Illuminate\Console\Command;
use Ferdinalaxewall\ServiceRepositoryGenerator\Facades\RepositoryGenerator;

class RepositoryGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository-name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for Generate Repository with Optional Model Name';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $repositoryName = $this->argument('repository-name');
            $modelName = $this->option('model');

            if(!empty($modelName)){
                if(!file_exists(app_path('Models/' . $this->option('model') . '.php'))){
                    if($this->confirm("Do you want to continue with create a \"{$this->option('model')}\" model?", true)){
                        $this->call("make:model", [
                            'name' => $this->option('model')
                        ]);

                        RepositoryGenerator::generate($repositoryName, false, $modelName);
                        RepositoryGenerator::generateBaseRepository();
                    }
                }else{
                    RepositoryGenerator::generate($repositoryName, false, $repositoryName);
                    RepositoryGenerator::generateBaseRepository();
                }
            }else{
                RepositoryGenerator::generate($repositoryName, true);
            }

        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
