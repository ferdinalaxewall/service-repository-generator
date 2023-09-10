<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Base;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\Filesystem;
use Ferdinalaxewall\ServiceRepositoryGenerator\Helpers\ConsoleLog;
use Ferdinalaxewall\ServiceRepositoryGenerator\Exceptions\ModelNotFoundException;

abstract class FileGenerator
{
    protected $files;
    protected $modelName;
    protected $isImplementClass;

    public function __construct()
    {
        $this->files = new Filesystem;
    }

    abstract public function getStubPath(): string;
    abstract public function getStubVariables(): array;
    abstract public function getSourceFilePath(): string;

    public function generate(string $modelName)
    {
        if(file_exists(app_path('Models/'.$modelName.'.php'))){
            $this->modelName = $modelName;
    
            $baseServiceFilePath = $this->getSourceFilePath();
            $this->makeDirectory(dirname($baseServiceFilePath));
    
            // Create Interface File
            $this->createFile($baseServiceFilePath, $this->getSourceFileContent());
    
            // Create Implement Class File
            $this->createFile($this->getSourceFilePath(true), $this->getSourceFileContent(true));
        }else{
            throw new ModelNotFoundException("Oops: \"{$modelName}\" model not found!");
        }
    }

    public function createFile($filePath, $fileContents)
    {
        if (!$this->files->exists($filePath)) {
            $this->files->put($filePath, $fileContents);
            ConsoleLog::info("File: {$filePath} created");
        } else {
            ConsoleLog::error("File: {$filePath} already exists");
        }
    }

    public function getSourceFileContent($isImplementClass = false)
    {
        $this->isImplementClass = $isImplementClass;
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{ '.$search.' }}' , $replace, $contents);
        }

        return $contents;

    }

    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) $this->files->makeDirectory($path, 0777, true, true);
        return $path;
    }
}