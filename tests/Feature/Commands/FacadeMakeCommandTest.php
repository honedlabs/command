<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Facades'));
});

it('makes', function () {
    $this->artisan('make:facade', [
        'name' => 'UserSession',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Facades/UserSession.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:facade', [
        '--force' => true,
    ])->expectsQuestion('What should the facade be named?', 'UserSession')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Facades/UserSession.php'));
});

it('accepts an underlying class', function () {
    $this->artisan('make:facade', [
        'name' => 'UserSession',
        '--force' => true,
        '--class' => '\\Honed\\Command\\Tests\\Stubs\\ProductCache',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Facades/UserSession.php'));
    $this->assertStringContainsString('use Honed\Command\Tests\Stubs\ProductCache;', file_get_contents(app_path('Facades/UserSession.php')));
});
