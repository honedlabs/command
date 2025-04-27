<?php

declare(strict_types=1);

use Honed\Command\Concerns\HasCache;
use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductCache;
use Illuminate\Database\Eloquent\Model;

class CacheModel extends Model
{
    use HasCache;

    protected static $cache = ProductCache::class;
}

it('has a cache', function () {
    expect(Product::cache())
        ->toBeInstanceOf(ProductCache::class);
});

it('caches value', function () {
    $product = product();

    expect($product)
        ->cached()->toBe(['name' => $product->name])
        ->forgetCached()->toBeNull();
});

it('can set cache', function () {
    $model = new CacheModel();

    expect($model)
        ->cache()->toBeInstanceOf(ProductCache::class);
});