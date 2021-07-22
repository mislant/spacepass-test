<?php

declare(strict_types=1);

namespace Spacepass;

use Iterator;
use SplFileInfo;

/**
 * File object collection interface
 *
 * @package Spacepass
 */
interface FileCollection extends Iterator
{
    public function current(): SplFileInfo;
}