<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Base;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\Filesystem;
use Ferdinalaxewall\ServiceRepositoryGenerator\Helpers\ConsoleLog;
use Ferdinalaxewall\ServiceRepositoryGenerator\Exceptions\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

abstract class FileGenerator
{
    /**
     * create an initial variable for the file system facades.
     *
     * @var \Illuminate\Filesystem\Filesystem $files
     */
    protected $files;

    /**
     * create an initial variable for the name of model.
     *
     * @var \Illuminate\Database\Eloquent\Model $modelName
     */
    protected $modelName;

    /**
     * create an initial variable for check the truthy or falsy condition.
     *
     * @var Boolean
     */
    protected $isImplementClass;

    /**
     * create a new FileGenerator instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->files = new Filesystem;
    }

    /**
     * abstraction class for getting the path of stubs.
     *
     * @return string
     */
    abstract public function getStubPath(): string;

    /**
     * abstraction class for getting the variables of stubs.
     *
     * @return array
     */
    abstract public function getStubVariables(): array;

    /**
     * abstraction class for getting the file source path.
     *
     * @return string
     */
    abstract public function getSourceFilePath(): string;

    /**
     * create a base function to generate class files.
     *
     * @param string $modelName
     *
     * @return void
     */
    public function generate(string $modelName): void
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

    /**
     * create a base function for creating files.
     *
     * @param string $filePath
     * @param mixed $fileContents
     *
     * @return void
     */
    public function createFile(string $filePath, mixed $fileContents): void
    {
        if (!$this->files->exists($filePath)) {
            $this->files->put($filePath, $fileContents);
            ConsoleLog::info("File: {$filePath} created");
        } else {
            ConsoleLog::error("File: {$filePath} already exists");
        }
    }

    /**
     * create a base function for getting the source of file content.
     *
     * @param bool $isImplementClass
     *
     * @return string|false
     */
    public function getSourceFileContent(bool $isImplementClass = false): string|false
    {
        $this->isImplementClass = $isImplementClass;

        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * create a base function for getting the contents of stubs.
     *
     * @param mixed $stub
     * @param array $stubVariables
     *
     * @return string|false
     */
    public function getStubContents(string|false $stub , array $stubVariables = []): string|false
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{ '.$search.' }}' , $replace, $contents);
        }

        return $contents;

    }

    /**
     * create a base function for getting the singular class name.
     *
     * @param string $name
     *
     * @return string
     */
    public function getSingularClassName(string $name): string
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * make the directory with allow entire permission 0777. include admin, user and guest.
     *
     * @param mixed $path
     *
     * @return string|Collection|array
     */
    protected function makeDirectory(mixed $path): string|Collection|array
    {
        if (! $this->files->isDirectory($path)) $this->files->makeDirectory($path, 0777, true, true);

        return $path;
    }
}
