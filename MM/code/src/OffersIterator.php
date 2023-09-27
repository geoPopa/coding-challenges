<?php

namespace MMarkets;

use Iterator;

class OffersIterator implements Iterator
{
    private int $position = 0;

    public function __construct(public array $offers = [])
    {
    }

    public function current(): mixed
    {
        return $this->offers[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->offers[$this->position]);
    }
}
