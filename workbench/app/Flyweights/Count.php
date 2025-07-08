<?php

declare(strict_types=1);

namespace Workbench\App\Flyweights;

use Honed\Command\Flyweight;

/**
 * @template T of int
 *
 * @extends \Honed\Command\Flyweight<T>
 */
class Count extends Flyweight
{
    /**
     * The value of the flyweight.
     *
     * @var int
     */
    protected $data = 0;

    /**
     * Get the value of the flyweight.
     *
     * @return T
     */
    public function get(): mixed
    {
        return $this->data;
    }

    /**
     * Handle the call to the flyweight.
     */
    public function call(): void
    {
        $this->data++;
    }
}
