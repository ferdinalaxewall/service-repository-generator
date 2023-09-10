<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceGenerator extends Facade
{
    /**
     * Get the registered name of the service-generator static component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'service-generator';
    }
}
