<?php

declare(strict_types=1);

namespace Spacepass;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Spacepass\Simple\RuntimeException as RuntimeExceptionImplementation;

final class TestTaskFactory
{
    private ?ContainerInterface $container;

    /**
     * @throws RuntimeException
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * @throws RuntimeException
     */
    private function setContainer(ContainerInterface $container): void
    {
        $this->ensureContainerHasRunner($container);
        $this->tryCreate($container);
        $this->container = $container;
    }

    /**
     * @throws RuntimeException
     */
    private function ensureContainerHasRunner(ContainerInterface $container): void
    {
        if (!$container->has(TestTask::class))
            throw new RuntimeExceptionImplementation("Container doesn't contain needed class!");
    }

    /**
     * @throws RuntimeException
     */
    private function tryCreate(ContainerInterface $container): void
    {
        try {
            $container->get(TestTask::class);
        } catch (\Exception $e) {
            if ($e instanceof ContainerExceptionInterface) {
                throw new RuntimeExceptionImplementation("Can't create instance! {$e->getMessage()}", $e->getCode(), $e);
            }
            throw new RuntimeExceptionImplementation($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function produce(): TestTask
    {
        $runner = $this->container->get(TestTask::class);
        $this->container = null;
        return $runner;
    }
}