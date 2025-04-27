<?php

declare(strict_types=1);

use Honed\Command\Attributes\Cache;
use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductCache;

it('has attribute', function () {
    $attribute = new Cache(ProductCache::class);
    expect($attribute)
        ->toBeInstanceOf(Cache::class)
        ->cache->toBe(ProductCache::class);

    expect(Product::class)
        ->toHaveAttribute(Cache::class);
});

