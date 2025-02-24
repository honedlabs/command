<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:concern', [
        'name' => 'HasProducts',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Concerns/HasProducts.php'));
});