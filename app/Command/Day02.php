<?php

namespace App\Command;

use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day02 extends Command
{
    protected static $defaultName = 'aoc:day02';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $games = $this->santasToolset->loadData('day02.txt');

        // A Rock
        // B Paper
        // C Sci

        // X Rock / 1pt / loose
        // Y Paper / 2pt / draw
        // Z Sci / 3pt / win

        // Win 6pt
        // Draw 3pt
        // Loose 0pt

        $count = 0;
        $countSecondGame = 0;
        foreach ($games as $game) {
            $moves = explode(" ", $game);

            $count += $this->getWinPoints(...$moves);

            switch ($moves[1]) {
                case 'X':
                    $count += 1;
                    $countSecondGame += 0;
                    $countSecondGame += $this->whatToPick($moves[0], 'loose');
                    break;
                case 'Y':
                    $count += 2;
                    $countSecondGame += 3;
                    $countSecondGame += $this->whatToPick($moves[0], 'draw');
                    break;
                case 'Z':
                    $count += 3;
                    $countSecondGame += 6;
                    $countSecondGame += $this->whatToPick($moves[0], 'win');
                    break;
            }
        }

        $output->writeln(sprintf('Solution for puzzle 02-1: <info>%s</info>', $count));
        $output->writeln(sprintf('Solution for puzzle 02-2: <info>%s</info>', $countSecondGame));

        return 0;
    }

    private function getWinPoints(string $playerA, string $playerB): int
    {
        switch ($playerA) {
            case 'A':
                if ($playerB == 'X') {
                    return 3;
                }

                if ($playerB == 'Y') {
                    return 6;
                }

                return 0;

            case 'B':
                if ($playerB == 'X') {
                    return 0;
                }

                if ($playerB == 'Y') {
                    return 3;
                }

                return 6;

            case 'C':
                if ($playerB == 'X') {
                    return 6;
                }

                if ($playerB == 'Y') {
                    return 0;
                }

                return 3;
        }
    }

    private function whatToPick(string $playerA, string $outcome): int
    {
        switch ($playerA) {
            case 'A':
                if ($outcome == 'win') {
                    return 2;
                } elseif ($outcome == 'loose') {
                    return 3;
                }

                return 1;

            case 'B':
                if ($outcome == 'win') {
                    return 3;
                } elseif ($outcome == 'loose') {
                    return 1;
                }

                return 2;

            case 'C':
                if ($outcome == 'win') {
                    return 1;
                } elseif ($outcome == 'loose') {
                    return 2;
                }

                return 3;
        }
    }
}