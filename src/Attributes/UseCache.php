<?php

declare(strict_types=1);

namespace Honed\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseCache
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Command\CacheManager>  $cacheClass
     * @return void
     */
    public function __construct(
        public string $cacheClass
    ) {}
}
