<?php

namespace App\Model;

class Day05_Stack
{
    /** @var array */
    private $stack = [];

    public function pushItem(string $name): void
    {
        array_push($this->stack, $name);
    }

    public function addItem(string $name): void
    {
        array_unshift($this->stack, $name);
    }

    public function addItems($items): void
    {
        $this->stack = array_merge($items, $this->stack);
    }

    public function popItem(): string
    {
        $item = array_shift($this->stack);
        return $item;
    }

    public function popItems($count): array
    {
        $items = array_splice($this->stack, 0, $count);
        return $items;
    }

    public function getFirstItem(): string
    {
        return isset($this->stack[0]) ? $this->stack[0] : '';
    }
}