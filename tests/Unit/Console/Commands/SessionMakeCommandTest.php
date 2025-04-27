<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Sessions'));
    File::cleanDirectory(app_path('Facades'));
});

it('makes', function () {
    $this->artisan('make:session', [
        'name' => 'UserSession',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Sessions/UserSession.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:session', [
        '--force' => true,
    ])->expectsQuestion('What should the session be named?', 'UserSession')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Sessions/UserSession.php'));
});

it('has facade option', function () {
    $this->artisan('make:session', [
        'name' => 'UserSession',
        '--facade' => true,
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Sessions/UserSession.php'));
    $this->assertFileExists(app_path('Facades/UserSession.php'));
});

