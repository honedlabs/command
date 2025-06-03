<?php

declare(strict_types=1);

namespace Honed\Command\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:modal')]
class ModalMakeCommand extends JsMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:modal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Javascript modal.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Modal';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/honed.modal.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Modals';
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the modal even if it already exists'],
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
                'E.g. Create',
            ],
        ];
    }
}
