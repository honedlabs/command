<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Repositories'));
});

it('makes', function () {
    $this->artisan('make:repository', [
        'name' => 'UserRepository',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Repositories/UserRepository.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:repository', [
        '--force' => true,
    ])->expectsQuestion('What should the repository be named?', 'UserRepository')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Repositories/UserRepository.php'));
});

it('has model stub', function () {
    $this->artisan('make:repository', [
        'name' => 'UserRepository',
        '--force' => true,
        '--model' => 'App\\Models\\User',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Repositories/UserRepository.php'));
});