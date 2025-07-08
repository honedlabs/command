<?php

declare(strict_types=1);

namespace Honed\Command;

/**
 * @template TReturn
 * @template TParam = mixed
 */
abstract class Flyweight
{
    /**
     * Get the value of the flyweight.
     *
     * @return TReturn
     */
    abstract public function get(): mixed;

    /**
     * Handle the call.
     */
    abstract public function call(): void;

    /**
     * Create a new instance of the flyweight.
     *
     * @param  TParam  ...$parameters
     */
    public static function make(...$parameters): static
    {
        if (app()->resolved(static::class)) {
            return app(static::class);
        }

        app()->scopedIf(
            static::class,
            // @phpstan-ignore-next-line new.static
            fn () => new static(...$parameters),
        );

        $flyweight = app(static::class);

        $flyweight->call();

        return $flyweight;
    }
}
