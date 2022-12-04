<?php

namespace App\Command;

use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day03 extends Command
{
    protected static $defaultName = 'aoc:day03';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $alphabet = array_merge(range('a', 'z'), range('A', 'Z'));
        $backpacks = $this->santasToolset->loadData('day03.txt');

        $count = 0;
        foreach ($backpacks as $backpack) {
            $compartments = str_split($backpack, strlen($backpack)/2);
            $compartments = array_map(fn($compartment) => str_split($compartment), $compartments);

            foreach ($compartments[0] as $item) {
                if (in_array($item, $compartments[1])) {
                    $itemValue = array_search($item, $alphabet)+1;
                    $count += $itemValue;
                    break;
                }
            }
        }
        $output->writeln(sprintf('Solution for puzzle 03-1: <info>%s</info>', $count));

        // Second puzzle
        $groups = array_chunk($backpacks, 3);
        $count = 0;
        foreach ($groups as $group) {
            $group = array_map(fn($group) => str_split($group), $group);
            $badge = array_intersect(...$group);
            $badge = array_shift($badge);
            $count += array_search($badge, $alphabet)+1;
            continue;
        }
        $output->writeln(sprintf('Solution for puzzle 03-2: <info>%s</info>', $count));

        return 0;
    }
}