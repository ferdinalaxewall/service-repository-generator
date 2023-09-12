<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Console\Commands;

use Illuminate\Console\Command;
use Ferdinalaxewall\ServiceRepositoryGenerator\Facades\ServiceGenerator;

class ServiceGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {service-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for Generate Service';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $serviceName = $this->argument('service-name');
            ServiceGenerator::generate($serviceName, true);

        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
