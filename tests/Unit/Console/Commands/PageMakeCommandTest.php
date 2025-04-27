<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(resource_path('js/Pages'));
});

it('makes', function () {
    $this->artisan('make:page', [
        'name' => 'Product/Index',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Product/Index.vue'));
});

it('prompts for a name', function () {
    $this->artisan('make:page', [
        '--force' => true,
    ])->expectsQuestion('What should the page be named?', 'Product/Edit')
        ->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Product/Edit.vue'));
});