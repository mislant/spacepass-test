<?php

declare(strict_types=1);

namespace Spacepass;

/**
 * Input interface
 *
 * This interface declares functionality of input parsing
 * and preparing in needed format
 *
 * @package Spacepass
 */
interface Input
{
    /**
     * @throws RuntimeException
     */
    public function getParsingDirectory(): string;

    /**
     * @throws RuntimeException
     */
    public function getParsingFilesExceptions(): array;
}