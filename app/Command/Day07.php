<?php
namespace App\Command;

use App\Model\Day07_Folder;
use App\Service\SantasToolset;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day07 extends Command
{
    protected static $defaultName = 'aoc:day07';

    private $santasToolset;

    public function __construct(SantasToolset $santasToolset, string $name = null)
    {
        $this->santasToolset = $santasToolset;

        parent::__construct($name);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $history = $this->santasToolset->loadData('day07.txt');

        $rootfs = new Day07_Folder('Santas Personal Files');

        $currentPath = $rootfs;

        foreach ($history as $line) {
            if ($line == "$ ls") {
                continue;
            }

            if (preg_match('/^\$ cd (.*)$/', $line, $matches)) {
                if ($matches[1] == '/') {
                    $currentPath = $rootfs;
                } elseif ($matches[1] == '..') {
                    $currentPath = $currentPath->getParent();
                } else {
                    $currentPath = $currentPath->getFolder($matches[1]);
                }
                continue;
            }

            if (preg_match('/^dir (.*)$/', $line, $matches)) {
                $currentPath->addFolder($matches[1]);
                continue;
            }

            if (preg_match('/^(.*) (.*)$/m', $line, $matches)) {
                $currentPath->addFile($matches[2], $matches[1]);
                continue;
            }
        }

        $folders = $rootfs->findChildrenWithSize(100000, false);
        $totalSize = array_reduce($folders, fn($i, $obj) => $i += $obj->getSize());

        $output->writeln(sprintf('Solution for puzzle 07-1: <info>%s</info>', $totalSize));

        // Puzzle 2
        $purgeSize = 30000000 - (70000000 - $rootfs->getSize());
        $folders = array_merge([$rootfs], $rootfs->findChildrenWithSize($purgeSize, true));

        $directorySize = min(array_map(fn($a) => $a->getSize(), $folders));
        $output->writeln(sprintf('Solution for puzzle 07-2: <info>%s</info>', $directorySize));

        return 0;
    }
}