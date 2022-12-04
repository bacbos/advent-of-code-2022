<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

final class SantasToolset
{
    public function loadData(string $fileName): array
    {
        $finder = new Finder();
        $finder->in(__DIR__ . '/../../var/data')->name($fileName)->files();

        $iterator = $finder->getIterator();
        $iterator->rewind();
        $file = $iterator->current();

        return explode(PHP_EOL, $file->getContents());
    }
}