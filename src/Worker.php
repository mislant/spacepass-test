<?php

declare(strict_types=1);

namespace Spacepass;

/**
 * Worker interface
 *
 * This interface represent unit of
 * work for test task
 *
 * @package Spacepass
 */
interface Worker
{
    /**
     * Makes pdf copy of file
     *
     * @throws RuntimeException
     */
    public function makePdfCopy(\SplFileInfo $file): void;
}