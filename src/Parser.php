<?php

declare(strict_types=1);

namespace Spacepass;

/**
 * Parser interface
 *
 * Interface of object that parses files
 *
 * @package Spacepass
 */
interface Parser
{
    /**
     * Parses files from
     * curtain directory
     *
     * @param string $directory
     * @param string[] $extensions
     *
     * @return FileCollection
     *
     * @throws RuntimeException
     */
    public function getFiles(string $directory, array $extensions): FileCollection;
}