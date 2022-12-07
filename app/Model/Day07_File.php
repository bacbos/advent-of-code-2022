<?php
namespace App\Model;

final class Day07_File
{
    /** @var string */
    private $name;

    /** @var int */
    private $size;

    public function __construct(string $name, int $size)
    {
        $this->name = $name;
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}