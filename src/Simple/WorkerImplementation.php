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
        $this->deleteCopyIfExists();
        $this->new($content);
    }

    private function deleteCopyIfExists()
    {
        if (file_exists($this->getCopyFullPath()))
            unlink($this->getCopyFullPath());
    }

    private function new(string $content)
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Kirill');
        $pdf->SetTitle('Pdf copy');
        $pdf->SetSubject('Pdf copy');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('times', 'BI', 20);
        $pdf->AddPage();
        $pdf->Write(0, $content, '', 0, 'C', true, 0, false, false, 0);
        $pdf->Output($this->getCopyFullPath(), 'F');
    }

    private function getCopyFullPath(): string
    {
        $name = "{$this->file->getFilename()}.pdf";
        $path = $this->file->getPath();
        return "$path/$name";
    }
}