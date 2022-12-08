<?php
namespace App\Command;

use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day08 extends Command
{
    protected static $defaultName = 'aoc:day08';

    private $santasToolset;

    private $forest;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->santasToolset->loadData('day08.txt');

        foreach ($data as $line) {
            $this->forest[] = str_split($line);
        }

        $visibleTrees = 0;
        $viewQualities = [];
        foreach ($this->forest as $row=>$lineOfTrees) {
            foreach ($lineOfTrees as $col=>$tree) {
                if ($this->isTreeVisible($row, $col)) {
                    $visibleTrees++;
                }

                $viewQualities[] = $this->calculateViewQuality($row, $col);
                $bestSpot = max($viewQualities);

            }
        }

        $output->writeln(sprintf('Solution for puzzle 08-1: <info>%s</info>', $visibleTrees));
        $output->writeln(sprintf('Solution for puzzle 08-2: <info>%s</info>', $bestSpot));

        return 0;
    }

    public function isTreeVisible(int $row, int $col): bool
    {
        $forestWidth = count($this->forest[0]);
        $forestHeight = count($this->forest);
        $treeHeight = $this->forest[$row][$col];

        if ($row == 0 ||
            $col == 0 ||
            $row == $forestHeight - 1 ||
            $col == $forestWidth -1
        ) {
            return true;
        }

        $isVisible = true;
        for ($i = 0; $i < $row; $i++) {
            if ($this->forest[$i][$col] >= $treeHeight) {
                $isVisible = false;
            }
        }
        if ($isVisible) {
            return true;
        }

        $isVisible = true;
        for ($i = $forestWidth - 1; $i > $row; $i--) {
            if ($this->forest[$i][$col] >= $treeHeight) {
                $isVisible = false;
            }
        }
        if ($isVisible) {
            return true;
        }

        $isVisible = true;
        for ($i = 0; $i < $col; $i++) {
            if ($this->forest[$row][$i] >= $treeHeight) {
                $isVisible = false;
            }
        }
        if ($isVisible) {
            return true;
        }

        $isVisible = true;
        for ($i = $forestHeight - 1; $i > $col; $i--) {
            if ($this->forest[$row][$i] >= $treeHeight) {
                $isVisible = false;
            }
        }
        if ($isVisible) {
            return true;
        }

        return false;
    }

    // puzzle 2
    public function calculateViewQuality(int $row, int $col)
    {
        $forestWidth = count($this->forest[0]);
        $forestHeight = count($this->forest);
        $treeHeight = $this->forest[$row][$col];

        if ($row == 0 ||
            $col == 0 ||
            $row == $forestHeight - 1 ||
            $col == $forestWidth -1
        ) {
            return 0;
        }

        $treesNorth = 0;
        $treesEast = 0;
        $treeSouth = 0;
        $treesWest = 0;

        // north
        for ($i = $row - 1; $i >= 0; $i--) {
            $treesNorth++;
            if ($this->forest[$i][$col] >= $treeHeight) {
                break;
            }
        }

        // east
        for ($i = $col + 1; $i < $forestHeight; $i++) {
            $treesEast++;
            if ($this->forest[$row][$i] >= $treeHeight) {
                break;
            }
        }

        // south
        for ($i = $row + 1; $i < $forestHeight; $i++) {
            $treeSouth++;
            if ($this->forest[$i][$col] >= $treeHeight) {
                break;
            }
        }

        // west
        for ($i = $col - 1; $i >= 0; $i--) {
            $treesWest++;
            if ($this->forest[$row][$i] >= $treeHeight) {
                break;
            }
        }

        return $treesNorth * $treesEast * $treeSouth * $treesWest;
    }
}