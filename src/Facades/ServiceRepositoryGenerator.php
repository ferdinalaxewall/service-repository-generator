<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceRepositoryGenerator extends Facade
{
    /**
     * Get the registered name of the service-repository-generator static component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'service-repository-generator';
    }
}