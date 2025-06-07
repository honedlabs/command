<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Responses'));
});

it('makes', function () {
    $this->artisan('make:response', [
        'name' => 'Download',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Responses/Download.php'));
});

it('responses for a name', function () {
    $this->artisan('make:response', [
        '--force' => true,
    ])->expectsQuestion('What should the response be named?', 'Download')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Responses/Download.php'));
});
