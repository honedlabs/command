<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:contract', [
        'name' => 'ShouldAct',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Contracts/ShouldAct.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:contract', [
        '--force' => true,
    ])->expectsQuestion('What should the contract be named?', 'Actionable')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Contracts/Actionable.php'));
});