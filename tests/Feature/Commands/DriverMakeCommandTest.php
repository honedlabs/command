<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Drivers'));
});

it('makes', function () {
    $this->artisan('make:driver', [
        'name' => 'RedisDriver',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Drivers/RedisDriver.php'));
});

it('drivers for a name', function () {
    $this->artisan('make:driver', [
        '--force' => true,
    ])->expectsQuestion('What should the driver be named?', 'RedisDriver')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Drivers/RedisDriver.php'));
});
