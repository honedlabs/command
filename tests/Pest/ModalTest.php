<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:modal', [
        'name' => 'Product/Create',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Modals/Product/Create.vue'));
});
