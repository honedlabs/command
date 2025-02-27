<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:concern', [
        'name' => 'HasProducts',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Concerns/HasProducts.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:concern', [
        '--force' => true,
    ])->expectsQuestion('What should the concern be named?', 'HasUser')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Concerns/HasUser.php'));
});