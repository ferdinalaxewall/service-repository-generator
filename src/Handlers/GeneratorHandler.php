<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Handlers;

use Illuminate\Support\Facades\Log;
use Ferdinalaxewall\ServiceRepositoryGenerator\Define;
use Ferdinalaxewall\ServiceRepositoryGenerator\Helpers\ConsoleLog;
use Ferdinalaxewall\ServiceRepositoryGenerator\Functions\ServiceGenerator;
use Ferdinalaxewall\ServiceRepositoryGenerator\Functions\RepositoryGenerator;
use Ferdinalaxewall\ServiceRepositoryGenerator\Exceptions\ModelNotFoundException;

class GeneratorHandler
{
    public function generateFromModel(string $modelName, string|array $generateFileType)
    {
        try {
            $generateFileType = is_array($generateFileType) ? $generateFileType : explode(',', $generateFileType);
        
            foreach ($generateFileType as $fileType) {
                $fileType = strtolower(trim($fileType));
                if(in_array($fileType, Define::AVAILABLE_TYPE)){
                    if($fileType == Define::REPOSITORY_TYPE){
                        (new RepositoryGenerator)->generate($modelName);
                        (new RepositoryGenerator)->generateBaseRepository();
                    }elseif($fileType == Define::SERVICE_TYPE){
                        (new ServiceGenerator)->generate($modelName);
                    }
                }
            }
        } catch (ModelNotFoundException $exception) {
            ConsoleLog::error($exception->getMessage());
        }
    }
}