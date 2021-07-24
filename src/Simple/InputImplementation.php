<?php

declare(strict_types=1);

namespace Spacepass\Simple;

use Spacepass\Input;
use Symfony\Component\Yaml\Yaml;

final class InputImplementation implements Input
{
    private string $config;
    private string $directory;
    private array $extensions;

    public function __construct(string $configFilePath)
    {
        $this->config = $configFilePath;
    }


    public function getParsingDirectory(): string
    {
        if (!isset($this->directory))
            $this->parseConfig();
        return $this->directory;
    }

    public function getParsingFilesExceptions(): array
    {
        if (!isset($this->extensions))
            $this->parseConfig();
        return $this->extensions;
    }

    private function parseConfig(): void
    {
        $config = Yaml::parse($this->getConfigContent());
        $this->directory = $config['directory'] ?? '';
        $this->extensions = $config['extensions'] ?? [];
    }

    private function getConfigContent(): string
    {
        try {
            $content = file_get_contents($this->config);
            if ($content === false) {
                throw new RuntimeException("Can't get config file content!");
            }
        } catch (\Throwable $t) {
            throw new RuntimeException();
        }
        return $content;
    }
}