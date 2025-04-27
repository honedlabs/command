<?php

declare(strict_types=1);

use Illuminate\Console\Command;

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('commands')
    ->expect('Honed\Command\Console\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);

arch('concerns')
    ->expect('Honed\Command\Concerns')
    ->toBeTraits();

arch('attributes')
    ->expect('Honed\Command\Attributes')
    ->toBeClasses();
