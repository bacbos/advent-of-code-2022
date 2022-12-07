<?php
namespace App\Model;

final class Day07_Folder
{
    /** @var string */
    private $name;

    /** @var Day07_Folder[] */
    private $folders = [];

    /** @var Day07_Folder */
    private $parent;

    /** @var Day07_File[] */
    private $files = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addFolder(string $name): void
    {
        if (!isset($this->folders[$name])) {
            $newFolder = new Day07_Folder($name);
            $newFolder->setParent($this);
            $this->folders[$name] = $newFolder;
        }
    }

    public function getFolder(string $name): Day07_Folder
    {
        return $this->folders[$name];
    }

    public function addFile(string $name, int $size): void
    {
        $this->files[$name] = new Day07_File($name, $size);
    }

    public function getParent(): Day07_Folder
    {
        return $this->parent;
    }

    public function setParent(Day07_Folder $parent): void
    {
        $this->parent = $parent;
    }

    public function getSize(): int
    {
        $size = 0;

        foreach ($this->folders as $folder)
        {
            $size += $folder->getSize();
        }

        foreach ($this->files as $file)
        {
            $size += $file->getSize();
        }

        return $size;
    }

    public function findChildrenWithSize(int $size, bool $min = false): array
    {
        $_folders = [];

        foreach ($this->folders as $folder) {
            if (
                (!$min && $folder->getSize() <= $size) ||
                ($min && $folder->getSize() >= $size)
            ){
                $_folders[] = $folder;
            }

            $_folders = array_merge($_folders, $folder->findChildrenWithSize($size, $min));
        }

        return $_folders;
    }
}