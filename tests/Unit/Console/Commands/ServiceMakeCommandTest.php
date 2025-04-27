<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Services'));
});

it('makes', function () {
    $this->artisan('make:service', [
        'name' => 'GithubService',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Services/GithubService.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:service', [
        '--force' => true,
    ])->expectsQuestion('What should the service be named?', 'GithubService')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Services/GithubService.php'));
});