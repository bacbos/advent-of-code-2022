<?php

namespace App\Command;

use App\Model\Day05_Stack;
use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day05 extends Command
{
    protected static $defaultName = 'aoc:day05';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $input = $this->santasToolset->loadData('day05.txt');

        /** @var Day05_Stack[] $stacks */
        $stacks = [];
        /** @var Day05_Stack[] $stacksSecondPuzzle */
        $stacksSecondPuzzle = [];
        $numberOfStacks = 9;

        for ($i = 1; $i <= $numberOfStacks; $i++) {
            $stacks[$i] = new Day05_Stack();
            $stacksSecondPuzzle[$i] = new Day05_Stack();
        }

        foreach ($input as $line) {
            if (preg_match("/^move ([0-9]{1,2}) from ([0-9]{1,2}) to ([0-9]{1,2})/m", $line, $matches)) {
                for ($i = 1; $i<=$matches[1]; $i++) {
                    $item = $stacks[$matches[2]]->popItem();
                    $stacks[$matches[3]]->addItem($item);
                }

                // second puzzle
                $items = $stacksSecondPuzzle[$matches[2]]->popItems($matches[1]);
                $stacksSecondPuzzle[$matches[3]]->addItems($items);
            } else {
                $_stacks = str_split($line, 4);
                foreach ($_stacks as $sK => $sI) {
                    preg_match('/\[(\w)\]/', $sI, $matches);
                    if ($matches) {
                        $stacks[$sK + 1]->pushItem($matches[1]);
                        $stacksSecondPuzzle[$sK + 1]->pushItem($matches[1]);
                    }
                }
            }
        }

        $firstItems = '';
        foreach ($stacks as $stack) {
            $firstItems .= $stack->getFirstItem();
        }

        $output->writeln(sprintf('Solution for puzzle 05-1: <info>%s</info>', $firstItems));

        $firstItems = '';
        foreach ($stacksSecondPuzzle as $stack) {
            $firstItems .= $stack->getFirstItem();
        }

        $output->writeln(sprintf('Solution for puzzle 05-2: <info>%s</info>', $firstItems));

        return 0;
    }
}