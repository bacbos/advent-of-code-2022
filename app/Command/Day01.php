<?php

namespace App\Command;

use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day01 extends Command
{
    protected static $defaultName = 'aoc:day01';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $items = $this->santasToolset->loadData('day01.txt');

        $caloriesCount = [];
        $count = 0;

        foreach ($items as $item) {
            if ($item == '') {
                $caloriesCount[] = $count;
                $count = 0;
                continue;
            }

            $count += $item;
        }
        arsort($caloriesCount);
        $caloriesCount = array_values($caloriesCount);

        $maxCalories = $caloriesCount[0];
        $output->writeln(sprintf('Solution for puzzle 01-1: <info>%s</info>', $maxCalories));

        $topThree = $caloriesCount[0] + $caloriesCount[1] + $caloriesCount[2];
        $output->writeln(sprintf('Solution for puzzle 01-2: <info>%s</info>', $topThree));

        return 0;
    }
}