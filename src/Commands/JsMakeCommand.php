<?php

declare(strict_types=1);

namespace Honed\Command\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

use function mb_trim;

abstract class JsMakeCommand extends GeneratorCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(mb_trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }

    /**
     * Get the file extension to use for the generated file.
     *
     * @return string
     */
    protected function getFileExtension()
    {
        return '.vue';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return resource_path('js/'.str_replace('\\', '/', $name).$this->getFileExtension());
    }
}
