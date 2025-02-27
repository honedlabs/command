<?php

declare(strict_types=1);

use Honed\Command\CommandServiceProvider;

it('publishes stubs', function () {
    $this->artisan('vendor:publish', [
        '--provider' => CommandServiceProvider::class,
        '--tag' => 'stubs',
    ])->assertSuccessful();

    $path = base_path('stubs/*.stub');

    expect(glob($path))
        ->toHaveCount(5);

    foreach (\glob(base_path('stubs/*.stub')) as $file) {
        $this->assertFileExists($file);
    }
});
