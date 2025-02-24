<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:page', [
        'name' => 'Product/Index',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Product/Index.vue'));
});
