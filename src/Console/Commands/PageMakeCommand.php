<?php

declare(strict_types=1);

namespace Honed\Command\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:page')]
class PageMakeCommand extends JsMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Javascript page.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Page';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/honed.page.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Pages';
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the page even if it already exists'],
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
                'E.g. Index',
            ],
        ];
    }
}
