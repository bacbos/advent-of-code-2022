<?php

namespace App\Command;

use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day04 extends Command
{
    protected static $defaultName = 'aoc:day04';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $assignments = $this->santasToolset->loadData('day04.txt');

        $count = 0;
        $countSecondPuzzle = 0;
        foreach ($assignments as $pair) {
            $sections = explode(',', $pair);
            $sections = array_map(fn($sections) => explode('-', $sections), $sections);

            if ($sections[0][0] >= $sections[1][0] && $sections[0][1] <= $sections[1][1]) {
                $count++;
            } elseif ($sections[1][0] >= $sections[0][0] && $sections[1][1] <= $sections[0][1]) {
                $count++;
            }

            // Second puzzle
            $section = array_map(fn($section) => range($section[0], $section[1]), $sections);
            if (array_intersect(...$section)) {
                $countSecondPuzzle++;
            }
        }
        $output->writeln(sprintf('Solution for puzzle 04-1: <info>%s</info>', $count));
        $output->writeln(sprintf('Solution for puzzle 04-1: <info>%s</info>', $countSecondPuzzle));

        return 0;
    }
}