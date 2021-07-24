<?php

declare(strict_types=1);

namespace Spacepass\Simple;

use Spacepass\FileCollection;
use Spacepass\Parser;
use Spacepass\Simple\FileCollection as FileCollectionImplementation;
use Symfony\Component\Finder\Finder;

/**
 * Parser implementation
 *
 * @package Spacepass\Simple
 */
final class ParserImplementation implements Parser
{
    private Finder $finder;

    public function __construct()
    {
        $this->finder = new Finder();
    }

    public function getFiles(string $directory, array $extensions): FileCollection
    {
        $this->configureFinder($directory, $extensions);
        return new FileCollectionImplementation($this->finder->getIterator());
    }

    private function configureFinder(string $directory, array $extensions)
    {
        $this->finder->files()
            ->in($directory);
        foreach ($extensions as $extension) {
            $this->finder->name("*.$extension");
        }
    }
}