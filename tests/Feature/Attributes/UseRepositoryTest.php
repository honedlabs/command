<?php

declare(strict_types=1);

use Honed\Command\Attributes\UseRepository;
use Workbench\App\Models\User;
use Workbench\App\Repositories\UserRepository;

it('has attribute', function () {
    $attribute = new UseRepository(UserRepository::class);
    expect($attribute)
        ->toBeInstanceOf(UseRepository::class)
        ->repositoryClass->toBe(UserRepository::class);

    expect(User::class)
        ->toHaveAttribute(UseRepository::class);
});
