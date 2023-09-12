<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Base;

use Illuminate\Support\Pluralizer;
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
     * create an initial variable for the name of class.
     *
     * @var String $className
     */
    protected $className;

    /**
     * create an initial variable for the path class.
     *
     * @var String $classPath
     */
    protected $classPath;

    /**
     * create an initial variable for the namespace of class.
     *
     * @var String $classNamespace
     */
    protected $classNamespace;

    /**
     * create an initial variable for the custom name of class.
     *
     * @var String $customClassPath
     */
    protected $customClassPath = null;

    /**
     * create an initial variable for check the truthy or falsy condition.
     *
     * @var Boolean
     */
    protected $isImplementClass;

    /**
     * create an initial variable for check the truthy or falsy custom (non service with repository) condition.
     *
     * @var Boolean
     */
    protected $isCustomGenerator;

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
     * @param string $classPath
     * @param bool $isCustomGenerator
     * @param bool $customClassPath
     *
     * @return void
     */
    public function generate(string $classPath, bool $isCustomGenerator = false, string $customClassPath = null): void
    {
        // Check if it's not custom generator and not existsing model
        if(!$isCustomGenerator && !file_exists(app_path('Models/'.$classPath.'.php'))) throw new ModelNotFoundException("Oops: \"{$classPath}\" model not found!");

        // Set attribute "className", "classPath", "classNamespace", "customClassPath" and "isCustomGenerator" in this class instance
        $this->classPath = $classPath;
        $this->className = $this->getSingularClassName($this->getClassNameFromPath($classPath));
        $this->classNamespace = $this->getClassNamespaceFromPath($classPath);
        $this->customClassPath = $customClassPath ?? $classPath;
        $this->isCustomGenerator = $isCustomGenerator;

        // Create Directory
        $baseServiceFilePath = $this->getSourceFilePath();
        $this->makeDirectory(dirname($baseServiceFilePath));

        // Create Interface File
        $this->createFile($baseServiceFilePath, $this->getSourceFileContent());

        // Create Implement Class File
        $this->createFile($this->getSourceFilePath(true), $this->getSourceFileContent(true));
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
     * create a base function for replacing class path into namespace format.
     *
     * @param string $classPath
     *
     * @return string
     */
    public function getClassNamespaceFromPath(string $classPath): string
    {
        return str_replace('/', '\\', $classPath);
    }

    /**
     * create a base function for get class name from class path.
     *
     * @param string $classPath
     *
     * @return string
     */
    public function getClassNameFromPath(string $classPath): string
    {
        return last(explode('/', $classPath));
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
