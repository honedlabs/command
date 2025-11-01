<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Decorators'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Decorators'));
});

it('makes', function () {
    $this->artisan('make:decorator', [
        'name' => 'StripeDecorator',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Decorators/StripeDecorator.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:decorator', [
        '--force' => true,
    ])->expectsQuestion('What should the decorator be named?', 'StripeDecorator')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Decorators/StripeDecorator.php'));
});
