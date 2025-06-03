<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Workbench\App\Models\User;
use Workbench\App\Repositories\UserRepository;

it('resolves repository model', function () {
    UserRepository::guessRepositoryNamesUsing(function ($class) {
        return Str::replaceLast('Models', 'Repositories', $class).'Repository';
    });

    expect(UserRepository::resolveRepositoryName(User::class))
        ->toBe(UserRepository::class);

    expect(UserRepository::repositoryForModel(User::class))
        ->toBeInstanceOf(UserRepository::class);

    UserRepository::flushState();
});

it('uses namespace', function () {
    UserRepository::useNamespace('');

    expect(UserRepository::resolveRepositoryName(User::class))
        ->toBe('Models\\UserRepository');

    UserRepository::flushState();
});
