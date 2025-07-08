<?php

declare(strict_types=1);

use Workbench\App\Flyweights\Count;

beforeEach(function () {
    $this->flyweight = Count::make();
});

it('creates a flyweight', function () {
    expect($this->flyweight)
        ->get()->toBe(1)
        ->get()->toBe(1)
        ->call()->toBeNull()
        ->get()->toBe(2);
});

it('only creates one instance', function () {
    $flyweight = Count::make();

    expect($this->flyweight)
        ->get()->toBe(1);

    expect($flyweight)
        ->get()->toBe(1);

    expect($this->flyweight)
        ->call()->toBeNull()
        ->get()->toBe(2);

    expect($flyweight)
        ->get()->toBe(2)
        ->call()->toBeNull()
        ->get()->toBe(3);

    expect($this->flyweight)
        ->get()->toBe(3);
});
