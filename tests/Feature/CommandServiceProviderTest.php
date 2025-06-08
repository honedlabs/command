<?php

declare(strict_types=1);

use Honed\Command\CommandServiceProvider;
use Illuminate\Support\Facades\File;

it('publishes stubs', function () {
    $path = base_path('stubs');

    if (file_exists($path)) {
        File::deleteDirectory($path);
    }

    $this->artisan('vendor:publish', [
        '--provider' => CommandServiceProvider::class,
        '--tag' => 'command-stubs',
    ])->assertSuccessful();

    $path = base_path('stubs/*.stub');
    expect(\count(glob($path)))
        ->toEqual(\count(glob(realpath(__DIR__.'/../../stubs').'/*.stub')));

    foreach (\glob($path) as $file) {
        $this->assertFileExists($file);
    }
})->skip();
