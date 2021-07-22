<?php

declare(strict_types=1);

namespace Spacepass;

use Psr\Log\LoggerInterface;

/**
 * Test task application
 *
 * @package Spacepass
 */
final class TestTask
{
    private Input $input;
    private Parser $parser;
    private Worker $worker;
    private LoggerInterface $logger;

    public function __construct(
        Input $input,
        Parser $parser,
        Worker $worker,
        LoggerInterface $logger
    )
    {
        $this->input = $input;
        $this->parser = $parser;
        $this->worker = $worker;
        $this->logger = $logger;
    }

    public function run(): int
    {
        try {
            return $this->process();
        } catch (RuntimeException $e) {
            return $this->handleError($e);
        }
    }

    /**
     * @throws RuntimeException
     */
    private function process(): int
    {
        $files = $this->getFilesFromInput();
        $this->makePdfCopies($files);
        return 0;
    }

    /**
     * @throws RuntimeException
     */
    private function getFilesFromInput(): FileCollection
    {
        $searchingDirectory = $this->input->getParsingDirectory();
        $this->logger->info("Begin file parsing from $searchingDirectory");
        $fileCollection = $this->parser->getFiles($searchingDirectory);
        $this->logger->info("Parsing was successful");
        return $fileCollection;
    }

    /**
     * @throws RuntimeException
     */
    private function makePdfCopies(FileCollection $files): void
    {
        $this->logger->info("Begin working with files");
        foreach ($files as $file) {
            $this->worker->makePdfCopy($file);
        }
        $this->logger->info("Work done successfully");
    }

    private function handleError(RuntimeException $e): int
    {
        $this->logger->error("Runtime error: {$e->getMessage()}!");
        return 1;
    }
}