<?php

declare(strict_types=1);

namespace Honed\Command\Tests\Stubs;

use Honed\Command\CacheManager;

/**
 * @extends \Honed\Command\CacheManager<\Honed\Command\Tests\Stubs\Product, array{name: string}>
 */
class ProductCache extends CacheManager
{
    /**
     * {@inheritdoc}
     */
    public function key($parameter)
    {
        return ['products', $parameter->id];
    }

    /**
     * {@inheritdoc}
     */
    public function value($parameter)
    {
        return $parameter->only('name');
    }
}
