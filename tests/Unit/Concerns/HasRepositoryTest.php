<?php

declare(strict_types=1);

use Honed\Command\Concerns\HasRepository;
use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\ProductRepository;
use Illuminate\Database\Eloquent\Model;

class RepositoryModel extends Model
{
    use HasRepository;

    protected static $repository = ProductRepository::class;
}

it('has a repository', function () {
    expect(Product::repository())
        ->toBeInstanceOf(ProductRepository::class);
});

it('can set repository', function () {
    $model = new RepositoryModel();

    expect($model)
        ->repository()->toBeInstanceOf(ProductRepository::class);
});
