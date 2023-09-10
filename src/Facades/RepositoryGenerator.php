<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class RepositoryGenerator extends Facade
{
    /**
     * Get the registered name of the repository-generator static component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'repository-generator';
    }
}