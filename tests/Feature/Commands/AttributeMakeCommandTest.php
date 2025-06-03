<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Attributes'));
});

it('makes', function () {
    $this->artisan('make:attribute', [
        'name' => 'Cache',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Attributes/Cache.php'));
});

it('attributes for a name', function () {
    $this->artisan('make:attribute', [
        '--force' => true,
    ])->expectsQuestion('What should the attribute be named?', 'Cache')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Attributes/Cache.php'));
});
