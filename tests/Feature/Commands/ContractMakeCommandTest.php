<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Contracts'));
});

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
    ])->expectsQuestion('What should the contract be named?', 'Action')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Contracts/Action.php'));
});
