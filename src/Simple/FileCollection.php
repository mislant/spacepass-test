<?php

declare(strict_types=1);

namespace Spacepass\Simple;

use Iterator;
use Spacepass\FileCollection as FileCollectionInterface;
use SplFileInfo;

/**
 * File collection
 *
 * @package Spacepass\Simple
 */
final class FileCollection implements FileCollectionInterface
{
    private Iterator $fileIterator;

    public function __construct(Iterator $fileIterator)
    {
        $this->fileIterator = $fileIterator;
    }

    public function next()
    {
        $this->fileIterator->next();
    }

    public function key()
    {
        return $this->fileIterator->key();
    }

    public function valid()
    {
        return $this->fileIterator->valid();
    }

    public function rewind()
    {
        $this->fileIterator->rewind();
    }

    public function current(): SplFileInfo
    {
        return $this->fileIterator->current();
    }

}