<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Workbench\App\Models\User;
use Workbench\App\Caches\UserCache;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->cache = new UserCache();
    $this->user = User::factory()->create();
});

it('has key', function () {
    expect($this->cache)
        ->key($this->user)->toBe(['users', $this->user->id])
        ->getKey($this->user)->toBe('users.1');
});

it('has value', function () {
    expect($this->cache)
        ->value($this->user)
        ->toBe($this->user->only('email'));
});

it('has duration', function () {
    expect($this->cache)
        ->duration()->toBeNull()
        ->getDuration()->toBe(0);
});

it('gets value', function () {
    expect(UserCache::get($this->user))
        ->toBe($this->user->only('email'));
});

it('flushes value', function () {
    UserCache::forget($this->user);

    expect(Cache::has($this->cache->getKey($this->user)))
        ->toBeFalse();
});

it('resolves cache model', function () {
    UserCache::guessCacheNamesUsing(function ($class) {
        return Str::replaceLast('Models', 'Caches', $class).'Cache';
    });

    expect(UserCache::resolveCacheName(User::class))
        ->toBe(UserCache::class);

    expect(UserCache::cacheForModel(User::class))
        ->toBeInstanceOf(UserCache::class);

    UserCache::flushState();
});

it('uses namespace', function () {
    UserCache::useNamespace('');

    expect(UserCache::resolveCacheName(User::class))
        ->toBe('Models\\UserCache');

    UserCache::flushState();
});
