<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:contract', [
        'name' => 'ShouldAct',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Contracts/ShouldAct.php'));
});