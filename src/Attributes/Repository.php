<?php

declare(strict_types=1);

namespace Honed\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Repository
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Command\Repository>  $repository
     * @return void
     */
    public function __construct(
        public string $repository
    ) {}
}
