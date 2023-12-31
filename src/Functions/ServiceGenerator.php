<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Functions;

use Illuminate\Support\Str;
use Ferdinalaxewall\ServiceRepositoryGenerator\Define;
use Ferdinalaxewall\ServiceRepositoryGenerator\Base\FileGenerator;

class ServiceGenerator extends FileGenerator
{
    /**
     * get the path of stubs.
     *
     * @return string
     */
    public function getStubPath(): string
    {
        return __DIR__ . '/../stubs/service/'. ($this->isImplementClass ? ($this->isCustomGenerator ? 'service-implement' : 'service-implement-with-repository') : 'service-interface') .'.stub';
    }

    /**
     * get the variables of stubs.
     *
     * @return array
     */
    public function getStubVariables(): array
    {
        $className = $this->getSingularClassName($this->className);

        return [
            'STUB_BASE_NAME'            => 'Services',
            'STUB_MODEL_NAME'           => $this->className,
            'STUB_MODEL_NAMESPACE'      => $this->classNamespace,
            'STUB_CAMELCASE_MODEL_NAME' => Str::camel($className),
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
        return base_path(Define::SERVICE_PATH) .'/' .$this->classPath . '/' .$this->className .'Service'. ($isImplementClass ? 'Imp' : '') .'.php';
    }
}
