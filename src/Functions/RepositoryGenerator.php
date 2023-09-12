<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Functions;

use Ferdinalaxewall\ServiceRepositoryGenerator\Define;
use Ferdinalaxewall\ServiceRepositoryGenerator\Helpers\ConsoleLog;
use Ferdinalaxewall\ServiceRepositoryGenerator\Base\FileGenerator;

class RepositoryGenerator extends FileGenerator
{
    /**
     * get the path of stubs.
     *
     * @return string
     */
    public function getStubPath(): string
    {
        return __DIR__ . '/../stubs/repository/'. ($this->isImplementClass ? ($this->isCustomGenerator ? 'repository-implement' : 'repository-implement-with-model') : 'repository-interface') .'.stub';
    }

    /**
     * get the variables of stubs.
     *
     * @return array
     */
    public function getStubVariables(): array
    {
        return [
            'STUB_BASE_NAME'                    => 'Repositories',
            'STUB_MODEL_NAME'                   => $this->className,
            'STUB_MODEL_NAMESPACE'              => $this->classNamespace,
            'STUB_CUSTOM_CLASS_NAME'            => $this->getClassNameFromPath($this->customClassPath),
            'STUB_CUSTOM_CLASS_NAMESPACE'       => $this->getClassNamespaceFromPath($this->customClassPath),
        ];
    }

    /**
     * get the file source path.
     *
     * @param bool $isImplementClass
     *
     * @return string
     */
    public function getSourceFilePath($isImplementClass = false): string
    {
        return base_path(Define::REPOSITORY_PATH) .'/' .$this->classPath .'/' .$this->className . 'Repository'. ($isImplementClass ? 'Imp' : '') .'.php';
    }

    /**
     * generate the base repository with existing stubs.
     *
     * @return void
     */
    public function generateBaseRepository(): void
    {
        $baseRepositoryFilePath = base_path(Define::REPOSITORY_PATH) . Define::BASE_REPOSITORY_FILE_PATH;
        if(!file_exists($baseRepositoryFilePath)){
            $this->makeDirectory(dirname($baseRepositoryFilePath));
            $this->createFile($baseRepositoryFilePath, $this->getStubContents(__DIR__ . '/../stubs/repository/base-repository.stub'));
        }
    }
}
