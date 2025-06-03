<?php

declare(strict_types=1);

use Honed\Command\Concerns\HasCache;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Caches\UserCache;
use Workbench\App\Models\User;

class CacheModel extends Model
{
    use HasCache;

    protected static $cache = UserCache::class;
}

it('has a cache', function () {
    expect(User::cache())
        ->toBeInstanceOf(UserCache::class);
});

it('caches value', function () {
    $user = User::factory()->create();

    expect($user)
        ->cached()->toBe(['email' => $user->email])
        ->forgetCached()->toBeNull();
});

it('can set cache', function () {
    $model = new CacheModel();

    expect($model)
        ->cache()->toBeInstanceOf(UserCache::class);
});
