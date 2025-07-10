<?php

declare(strict_types=1);

use Honed\Command\Attributes\UseCache;
use Workbench\App\Caches\UserCache;
use Workbench\App\Models\User;

it('has attribute', function () {
    $attribute = new UseCache(UserCache::class);
    
    expect($attribute)
        ->toBeInstanceOf(UseCache::class)
        ->cacheClass->toBe(UserCache::class);

    expect(User::class)
        ->toHaveAttribute(UseCache::class);
});
