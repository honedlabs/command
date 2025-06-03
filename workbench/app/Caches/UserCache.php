<?php

declare(strict_types=1);

namespace Workbench\App\Caches;

use Honed\Command\CacheManager;

/**
 * @extends \Honed\Command\CacheManager<\Workbench\App\Models\User, array{name: string}>
 */
class UserCache extends CacheManager
{
    /**
     * {@inheritdoc}
     */
    public function key($parameter)
    {
        return ['users', $parameter->id];
    }

    /**
     * {@inheritdoc}
     */
    public function value($parameter)
    {
        return $parameter->only('email');
    }
}
