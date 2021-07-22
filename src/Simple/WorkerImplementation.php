<?php

declare(strict_types=1);

namespace Spacepass\Simple;

use Psr\Log\LoggerInterface;
use Spacepass\Worker;
use SplFileInfo;

/**
 * Worker implementation
 *
 * @package Spacepass\Simple
 */
final class WorkerImplementation implements Worker
{
    private SplFileInfo $file;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function makePdfCopy(SplFileInfo $file): void
    {
        $this->setFile($file);
        $this->makeCopy();
    }

    private function setFile(SplFileInfo $file): void
    {
        $this->logger->info("File {$file->getBasename()} in work");
        $this->ensureFileIsCorrect($file);
        $this->ensureDirectoryHasAccess($file->getPathInfo());
        $this->file = $file;
    }

    /**
     * Checks if file is file and readable
     *
     * @throws RuntimeException
     */
    private function ensureFileIsCorrect(SplFileInfo $file): void
    {
        if (!$file->isFile()) {
            throw new RuntimeException("{$file->getBasename()} isn't file");
        }
        if (!$file->isReadable()) {
            throw new RuntimeException("{$file->getBasename()} isn't readable!");
        }
    }

    /**
     * Checks if directory is writable
     *
     * @param SplFileInfo $directory
     */
    private function ensureDirectoryHasAccess(SplFileInfo $directory): void
    {
        if (!$directory->isWritable()) {
            throw new RuntimeException("File directory isn't writable!");
        }
    }

    private function makeCopy(): void
    {
        try {
            $this->createNew($this->getFileContent());
        } catch (\Throwable $t) {
            $this->logger->error($t->getMessage());
            throw new RuntimeException("Something gone wrong while file creating!");
        }
    }

    private function getFileContent(): string
    {
        return file_get_contents($this->file->getRealPath());
    }

    private function createNew(string $content): void
    {
        file_put_contents($this->getCopyFullPath(), $content);
    }

    private function getCopyFullPath(): string
    {
        $name = "{$this->file->getFilename()}.pdf";
        $path = $this->file->getPath();
        return "$path/$name";
    }
}