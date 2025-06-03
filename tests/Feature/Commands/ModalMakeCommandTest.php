<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(resource_path('js/Modals'));
});

it('makes', function () {
    $this->artisan('make:modal', [
        'name' => 'Product/Create',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Modals/Product/Create.vue'));
});

it('prompts for a name', function () {
    $this->artisan('make:modal', [
        '--force' => true,
    ])->expectsQuestion('What should the modal be named?', 'Product/Edit')
        ->assertSuccessful();

    $this->assertFileExists(resource_path('js/Modals/Product/Edit.vue'));
});
