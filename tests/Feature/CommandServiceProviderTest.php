<?php

declare(strict_types=1);

use Honed\Command\CommandServiceProvider;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->path = base_path('stubs');
});

afterEach(function () {
    File::deleteDirectory($this->path);
});

it('publishes stubs', function () {
    if (file_exists($this->path)) {
        File::deleteDirectory($this->path);
    }

    $this->artisan('vendor:publish', [
        '--provider' => CommandServiceProvider::class,
        '--tag' => 'command-stubs',
    ])->assertSuccessful();

    $this->path = base_path('stubs/*.stub');
    expect(\count(glob($this->path)))
        ->toEqual(\count(glob(realpath(__DIR__.'/../../stubs').'/*.stub')));

    foreach (\glob($this->path) as $file) {
        $this->assertFileExists($file);
    }
});
