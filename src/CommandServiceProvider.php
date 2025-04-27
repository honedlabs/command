<?php

declare(strict_types=1);

namespace Honed\Command;

use Honed\Command\Console\Commands\BuilderMakeCommand;
use Honed\Command\Console\Commands\CacheMakeCommand;
use Honed\Command\Console\Commands\ConcernMakeCommand;
use Honed\Command\Console\Commands\ContractMakeCommand;
use Honed\Command\Console\Commands\FacadeMakeCommand;
use Honed\Command\Console\Commands\InvokableMakeCommand;
use Honed\Command\Console\Commands\ModalMakeCommand;
use Honed\Command\Console\Commands\PageMakeCommand;
use Honed\Command\Console\Commands\PartialMakeCommand;
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
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'stubs');

        if ($this->app->runningInConsole()) {
            $this->commands([
                BuilderMakeCommand::class,
                CacheMakeCommand::class,
                ConcernMakeCommand::class,
                ContractMakeCommand::class,
                FacadeMakeCommand::class,
                InvokableMakeCommand::class,
                ModalMakeCommand::class,
                PageMakeCommand::class,
                PartialMakeCommand::class,
                QueryMakeCommand::class,
                RepositoryMakeCommand::class,
                ServiceMakeCommand::class,
                SessionMakeCommand::class,
            ]);
        }
    }
}
