<?php

declare(strict_types=1);

use Honed\Command\Tests\Stubs\Product;
use Honed\Command\Tests\Stubs\Status;
use Honed\Command\Tests\TestCase;
use Illuminate\Support\Str;

uses(TestCase::class)
    ->in(__DIR__);

function product(?string $name = null): Product
{
    return Product::create([
        'public_id' => Str::uuid(),
        'name' => $name ?? fake()->unique()->word(),
        'description' => fake()->sentence(),
        'price' => fake()->randomNumber(4),
        'best_seller' => fake()->boolean(),
        'status' => fake()->randomElement(Status::cases()),
        'created_at' => now()->subDays(fake()->randomNumber(2)),
    ]);
}
