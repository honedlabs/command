<?php

declare(strict_types=1);

namespace Honed\Command\Tests\Stubs;

use Honed\Command\Repository;

/**
 * @template TModel of \Honed\Command\Tests\Stubs\Product
 */
class ProductRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @param  TModel  $product
     */
    public function __construct(
        protected Product $product
    ) {}
}
