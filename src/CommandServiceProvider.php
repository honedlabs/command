<?php

declare(strict_types=1);

namespace Honed\Command;

use Honed\Command\Console\Commands\BuilderMakeCommand;
use Honed\Command\Console\Commands\ConcernMakeCommand;
use Honed\Command\Console\Commands\ContractMakeCommand;
use Honed\Command\Console\Commands\ModalMakeCommand;
use Honed\Command\Console\Commands\PageMakeCommand;
use Honed\Command\Console\Commands\PartialMakeCommand;
use Honed\Command\Console\Commands\ServiceMakeCommand;
use Illuminate\Support\ServiceProvider;

final class CommandServiceProvider extends ServiceProvider
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
                ConcernMakeCommand::class,
                ContractMakeCommand::class,
                ModalMakeCommand::class,
                PageMakeCommand::class,
                PartialMakeCommand::class,
                ServiceMakeCommand::class,
            ]);
        }
    }
}
