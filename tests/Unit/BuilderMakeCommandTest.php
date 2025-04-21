<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Builders'));
});

it('makes', function () {
    $this->artisan('make:builder', [
        'name' => 'UserBuilder',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Builders/UserBuilder.php'));
});

it('accepts a model option', function () {
    // Create a model
    $this->artisan('make:model', [
        'name' => 'Product',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Models/Product.php'));

    // Then create the builder
    $this->artisan('make:builder', [
        'name' => 'ProductBuilder',
        '--force' => true,
        '--model' => 'Product',
    ])->assertSuccessful();

    $builder = file_get_contents(app_path('Builders/ProductBuilder.php'));
    expect($builder)->toContain('@template TModel of \App\Models\Product');

    $model = file_get_contents(app_path('Models/Product.php'));
    expect($model)->toContain('return new ProductBuilder($query);');
});

it('prompts for a name', function () {
    $this->artisan('make:builder', [
        '--force' => true,
    ])->expectsQuestion('What should the builder be named?', 'UserBuilder')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Builders/UserBuilder.php'));
});
