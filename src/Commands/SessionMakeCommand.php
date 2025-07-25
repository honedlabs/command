<?php

declare(strict_types=1);

namespace Honed\Command\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

use function class_basename;
use function trim;

#[AsCommand(name: 'make:session')]
class SessionMakeCommand extends GeneratorCommand implements PromptsForMissingInput
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new session class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Session';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/honed.session.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Sessions';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $name = ($this->qualifyClass($this->getNameInput()));

        $this->call('make:facade', [
            'name' => class_basename($name),
            '--class' => $name,
            '--force' => (bool) $this->option('force'),
        ]);

        return $class;
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['facade', 'f', InputOption::VALUE_NONE, 'Create a facade for the session'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the session already exists'],
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
                'What should the '.mb_strtolower($this->type).' be named?',
                'E.g. UserSession',
            ],
        ];
    }
}
