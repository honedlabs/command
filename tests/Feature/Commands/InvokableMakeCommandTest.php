<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Invokables'));
});

it('makes', function () {
    $this->artisan('make:invokable', [
        'name' => 'GenerateUserInvoice',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Invokables/GenerateUserInvoice.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:invokable', [
        '--force' => true,
    ])->expectsQuestion('What should the invokable be named?', 'GenerateUserInvoice')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Invokables/GenerateUserInvoice.php'));
});
