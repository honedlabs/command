<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Caches'));
});

it('makes', function () {
    $this->artisan('make:cache', [
        'name' => 'UserCache',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Caches/UserCache.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:cache', [
        '--force' => true,
    ])->expectsQuestion('What should the cache be named?', 'UserCache')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Caches/UserCache.php'));
});
