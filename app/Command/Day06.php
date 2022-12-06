<?php

namespace App\Command;

use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day06 extends Command
{
    protected static $defaultName = 'aoc:day06';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $buffer = str_split($this->santasToolset->loadData('day06.txt')[0]);

        $messageMarker = null;
        $messageMarkerSecondPuzzle = null;

        $offset = 0;
        while ($offset < count($buffer)) {
            $check = array_slice($buffer, $offset, 4);
            $checkSecondPuzzle = array_slice($buffer, $offset, 14);

            if (!$messageMarker && $this->isMessageMarker($check, 4)) {
                $messageMarker = $offset+4;
            }

            if (!$messageMarkerSecondPuzzle && $this->isMessageMarker($checkSecondPuzzle, 14)) {
                $messageMarkerSecondPuzzle = $offset+14;
            }

            $offset++;
        }

        $output->writeln(sprintf('Solution for puzzle 06-1: <info>%s</info>', $messageMarker));
        $output->writeln(sprintf('Solution for puzzle 06-2: <info>%s</info>', $messageMarkerSecondPuzzle));

        return 0;
    }

    private function isMessageMarker(array $buffer, int $length)
    {
        return count(array_unique($buffer)) == $length;
    }
}