<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceRepositoryGenerator extends Facade
{
    /**
     * Get the registered name of the generator-handler static component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'generator-handler';
    }
}
