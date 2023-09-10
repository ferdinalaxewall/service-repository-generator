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
        return __DIR__ . '/../stubs/repository/'. ($this->isImplementClass ? 'repository-implement-with-model' : 'repository-interface') .'.stub';
    }

    /**
     * get the variables of stubs.
     *
     * @return array
     */
    public function getStubVariables(): array
    {
        $className = $this->getSingularClassName($this->modelName);

        return [
            'STUB_BASE_NAME'            => 'Repositories',
            'STUB_MODEL_NAME'           => $className,
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
        return base_path(Define::REPOSITORY_PATH) .'/' .$this->getSingularClassName($this->modelName) .'/' .$this->getSingularClassName($this->modelName) . 'Repository'. ($isImplementClass ? 'Imp' : '') .'.php';
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
            ConsoleLog::info("File: {$baseRepositoryFilePath} created");
        }
    }
}
