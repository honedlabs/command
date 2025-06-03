<?php

declare(strict_types=1);

use Honed\Command\Attributes\Repository;
use Workbench\App\Models\User;
use Workbench\App\Repositories\UserRepository;

it('has attribute', function () {
    $attribute = new Repository(UserRepository::class);
    expect($attribute)
        ->toBeInstanceOf(Repository::class)
        ->repository->toBe(UserRepository::class);

    expect(User::class)
        ->toHaveAttribute(Repository::class);
});
