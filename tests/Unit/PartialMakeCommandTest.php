<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(resource_path('js/Pages'));
});

it('makes', function () {
    $this->artisan('make:partial', [
        'name' => 'ProductCard',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Partials/ProductCard.vue'));
    $this->assertFileExists(resource_path('js/Pages/Partials/index.ts'));

    $component = \file_get_contents(resource_path('js/Pages/Partials/ProductCard.vue'));
    expect($component)->toContain('<script setup lang="ts">');

    $index = \file_get_contents(resource_path('js/Pages/Partials/index.ts'));
    expect($index)->toContain('export { default as ProductCard } from \'./ProductCard.vue\'');
});

it('prompts for a name', function () {
    $this->artisan('make:partial', [
        '--force' => true,
    ])->expectsQuestion('What should the partial be named?', 'ProductCard')
        ->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Partials/ProductCard.vue'));
    $this->assertFileExists(resource_path('js/Pages/Partials/index.ts'));
});

it('nests partials', function () {
    $this->artisan('make:partial', [
        'name' => 'Product/ProductCard',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Product/Partials/ProductCard.vue'));
    $this->assertFileExists(resource_path('js/Pages/Product/Partials/index.ts'));

    $component = \file_get_contents(resource_path('js/Pages/Product/Partials/ProductCard.vue'));
    expect($component)->toContain('<script setup lang="ts">');

    $index = \file_get_contents(resource_path('js/Pages/Product/Partials/index.ts'));
    expect($index)->toContain('export { default as ProductCard } from \'./ProductCard.vue\'');
});

it('can specify an extension', function () {
    $this->artisan('make:partial', [
        'name' => 'utils',
        '--extension' => 'ts',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Partials/utils.ts'));
    $this->assertFileExists(resource_path('js/Pages/Partials/index.ts'));

    $index = \file_get_contents(resource_path('js/Pages/Partials/index.ts'));
    expect($index)->toContain('export * from \'./utils\'');
});
