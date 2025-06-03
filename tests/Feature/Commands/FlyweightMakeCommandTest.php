<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Flyweights'));
});

it('makes', function () {
    $this->artisan('make:flyweight', [
        'name' => 'UserFlyweight',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Flyweights/UserFlyweight.php'));
});

it('flyweights for a name', function () {
    $this->artisan('make:flyweight', [
        '--force' => true,
    ])->expectsQuestion('What should the flyweight be named?', 'UserFlyweight')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Flyweights/UserFlyweight.php'));
});
