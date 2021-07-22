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
    public function getParsingDirectory(): string;
}