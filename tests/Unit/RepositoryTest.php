<?php

declare(strict_types=1);

use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductRepository;


it('resolves repository model', function () {
    ProductRepository::guessRepositoryNamesUsing(function ($class) {
        return $class.'Repository';
    });

    expect(ProductRepository::resolveRepositoryName(Product::class))
        ->toBe('Honed\\Command\\Tests\\Stubs\\ProductRepository');

    expect(ProductRepository::repositoryForModel(Product::class))
        ->toBeInstanceOf(ProductRepository::class);

    ProductRepository::flushState();
});

it('uses namespace', function () {
    ProductRepository::useNamespace('');

    expect(ProductRepository::resolveRepositoryName(Product::class))
        ->toBe('Honed\\Command\\Tests\\Stubs\\ProductRepository');

    ProductRepository::flushState();
});
