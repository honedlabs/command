<?php

declare(strict_types=1);

namespace Honed\Command;

use Illuminate\Support\Facades\Pipeline;

/**
 * @template TPayload of mixed
 */
abstract class Process
{
    /**
     * The tasks to be sequentially executed.
     *
     * @var array<int, class-string>
     */
    protected array $tasks = [];

    /**
     * The method to call on each pipe.
     */
    protected string $method = 'handle';

    /**
     * Run the process.
     *
     * @param  TPayload  $payload
     */
    public function run(mixed $payload): mixed
    {
        return Pipeline::send($payload)
            ->through($this->tasks)
            ->via($this->method)
            ->thenReturn();
    }
}
