<?php

declare(strict_types=1);

namespace Honed\Command;

use Honed\Command\Console\Commands\AttributeMakeCommand;
use Honed\Command\Console\Commands\BuilderMakeCommand;
use Honed\Command\Console\Commands\CacheMakeCommand;
use Honed\Command\Console\Commands\ConcernMakeCommand;
use Honed\Command\Console\Commands\ContractMakeCommand;
use Honed\Command\Console\Commands\DriverMakeCommand;
use Honed\Command\Console\Commands\FacadeMakeCommand;
use Honed\Command\Console\Commands\FlyweightMakeCommand;
use Honed\Command\Console\Commands\InvokableMakeCommand;
use Honed\Command\Console\Commands\ModalMakeCommand;
use Honed\Command\Console\Commands\PageMakeCommand;
use Honed\Command\Console\Commands\PartialMakeCommand;
use Honed\Command\Console\Commands\PromptMakeCommand;
use Honed\Command\Console\Commands\QueryMakeCommand;
use Honed\Command\Console\Commands\RepositoryMakeCommand;
use Honed\Command\Console\Commands\ServiceMakeCommand;
use Honed\Command\Console\Commands\SessionMakeCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                AttributeMakeCommand::class,
                BuilderMakeCommand::class,
                CacheMakeCommand::class,
                ConcernMakeCommand::class,
                ContractMakeCommand::class,
                DriverMakeCommand::class,
                FacadeMakeCommand::class,
                FlyweightMakeCommand::class,
                InvokableMakeCommand::class,
                ModalMakeCommand::class,
                PageMakeCommand::class,
                PartialMakeCommand::class,
                PromptMakeCommand::class,
                QueryMakeCommand::class,
                RepositoryMakeCommand::class,
                ServiceMakeCommand::class,
                SessionMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'command-stubs');
    }
}
