<?php

declare(strict_types=1);

namespace Honed\Command\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:facade')]
class FacadeMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:facade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new facade class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Facade';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/honed.facade.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(\trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../../..'.$stub;
    }

    /**
     * Get the FQCN of the underlying class.
     *
     * @return string|null
     */
    protected function getUnderlyingClass()
    {
        /** @var string|null */
        $class = $this->option('class');

        if (! $class) {
            return null;
        }

        if (Str::endsWith($class, '.php')) {
            $class = Str::substr($class, 0, -4);
        }

        return Str::of($class)
            ->replace('/', '\\')
            ->studly()
            ->toString();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Facades';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $class = $this->getUnderlyingClass();

        return $this->replaceNamespace($stub, $name)
            ->replaceObject($stub, $class)
            ->replaceDoubleLineBreaks($stub)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the object for the given stub.
     *
     * @param  string  $stub
     * @param  string|null  $class
     * @return $this
     */
    protected function replaceObject(&$stub, $class)
    {
        $searches = [
            ['DummyObject', 'DummyObjectClass', 'DummyObjectNamespace'],
            ['{{ object }}', '{{ objectClass }}', '{{ objectNamespace }}'],
            ['{{object}}', '{{objectClass}}', '{{objectNamespace}}'],
        ];

        $object = $this->getObject($class);
        $objectClass = $this->getObjectClass($class);
        $objectNamespace = $this->getObjectNamespace($class);

        foreach ($searches as $search) {
            $stub = \str_replace(
                $search,
                [$object, $objectClass, $objectNamespace],
                $stub
            );
        }

        return $this;
    }

    /**
     * Get the class basename of the object.
     *
     * @param  string|null  $class
     * @return string
     */
    protected function getObject($class)
    {
        if (! $class) {
            return '';
        }

        $class = \class_basename($class);

        return "{$class}::class";
    }

    /**
     * Get the namespace of the object.
     *
     * @param  string|null  $class
     * @return string
     */
    protected function getObjectNamespace($class)
    {
        if (! $class) {
            return '';
        }

        $class = ltrim($class, '\\/');

        return "use {$class};";
    }

    /**
     * Get the object for the given class.
     *
     * @param  string|null  $class
     * @return string
     */
    protected function getObjectClass($class)
    {
        if (! $class) {
            return '';
        }

        return Str::start($class, '\\');
    }

    /**
     * Replace all double line breaks with a single line break.
     *
     * @param  string  &$stub
     *
     * @param-out string|null $stub
     *
     * @return $this
     */
    protected function replaceDoubleLineBreaks(&$stub)
    {
        // Replace 3 or more newlines with 2 to preserve single blank lines
        $stub = preg_replace('/\n{3,}/', "\n\n", (string) $stub);
        $stub = preg_replace('/(\r\n){3,}/', "\r\n\r\n", (string) $stub);

        return $this;
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['class', 'c', InputOption::VALUE_REQUIRED, 'The underlying class of the facade'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the facade already exists'],
        ];
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string,mixed>
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => [
                'What should the '.strtolower($this->type).' be named?',
                'E.g. UserSession',
            ],
            'class' => [
                'What should the underlying class of the facade be?',
                'E.g. App\\Sessions\\UserSession',
            ],
        ];
    }
}
