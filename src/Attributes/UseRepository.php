<?php

declare(strict_types=1);

namespace Honed\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseRepository
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Command\Repository>  $repositoryClass
     * @return void
     */
    public function __construct(
        public string $repositoryClass
    ) {}
}
