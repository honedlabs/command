<?php

declare(strict_types=1);

use Honed\Command\CacheManager;
use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductCache;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->cache = new ProductCache();
    $this->product = product();
});
it('has key', function () {
    expect($this->cache)
        ->key($this->product)->toBe(['products', $this->product->id])
        ->getKey($this->product)->toBe('products.1');
});

it('has value', function () {
    expect($this->cache)
        ->value($this->product)
        ->toBe($this->product->only('name'));
});

it('has duration', function () {
    expect($this->cache)
        ->duration()->toBeNull()
        ->getDuration()->toBe(0);
});

it('gets value', function () {
    expect(ProductCache::get($this->product))
        ->toBe($this->product->only('name'));
});

it('flushes value', function () {
    ProductCache::forget($this->product);

    expect(Cache::has($this->cache->getKey($this->product)))
        ->toBeFalse();
});

it('resolves cache model', function () {
    ProductCache::guessCacheNamesUsing(function ($class) {
        return $class.'Cache';
    });

    expect(ProductCache::resolveCacheName(Product::class))
        ->toBe('Honed\\Command\\Tests\\Stubs\\ProductCache');

    expect(ProductCache::cacheForModel(Product::class))
        ->toBeInstanceOf(ProductCache::class);

    ProductCache::flushState();
});

it('uses namespace', function () {
    ProductCache::useNamespace('');

    expect(ProductCache::resolveCacheName(Product::class))
        ->toBe('Honed\\Command\\Tests\\Stubs\\ProductCache');

    ProductCache::flushState();
});

