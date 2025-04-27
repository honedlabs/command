<?php

declare(strict_types=1);

use Honed\Command\Attributes\Repository;
use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductRepository;

it('has attribute', function () {
    $attribute = new Repository(ProductRepository::class);
    expect($attribute)
        ->toBeInstanceOf(Repository::class)
        ->repository->toBe(ProductRepository::class);

    expect(Product::class)
        ->toHaveAttribute(Repository::class);
});

