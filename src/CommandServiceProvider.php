<?php

declare(strict_types=1);

namespace Honed\Command;

use Honed\Command\Commands\AttributeMakeCommand;
use Honed\Command\Commands\BuilderMakeCommand;
use Honed\Command\Commands\CacheMakeCommand;
use Honed\Command\Commands\ConcernMakeCommand;
use Honed\Command\Commands\ContractMakeCommand;
use Honed\Command\Commands\DriverMakeCommand;
use Honed\Command\Commands\FacadeMakeCommand;
use Honed\Command\Commands\FlyweightMakeCommand;
use Honed\Command\Commands\InvokableMakeCommand;
use Honed\Command\Commands\ModalMakeCommand;
use Honed\Command\Commands\PageMakeCommand;
use Honed\Command\Commands\PartialMakeCommand;
use Honed\Command\Commands\PromptMakeCommand;
use Honed\Command\Commands\QueryMakeCommand;
use Honed\Command\Commands\RepositoryMakeCommand;
use Honed\Command\Commands\ResponseMakeCommand;
use Honed\Command\Commands\ServiceMakeCommand;
use Honed\Command\Commands\SessionMakeCommand;
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
                ResponseMakeCommand::class,
                ServiceMakeCommand::class,
                SessionMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'command-stubs');
    }
}
