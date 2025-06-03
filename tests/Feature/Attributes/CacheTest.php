<?php

declare(strict_types=1);

use App\Caches\UserCache;
use Honed\Command\Attributes\Cache;
use Workbench\App\Models\User;

it('has attribute', function () {
    $attribute = new Cache(UserCache::class);
    expect($attribute)
        ->toBeInstanceOf(Cache::class)
        ->cache->toBe(UserCache::class);

    expect(User::class)
        ->toHaveAttribute(Cache::class);
});
