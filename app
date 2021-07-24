#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Spacepass\TestTaskFactory;

try {
    $factory = new TestTaskFactory(
        (new \DI\ContainerBuilder())
            ->addDefinitions(require __DIR__ . '/di.php')
            ->build()
    );
} catch (\Spacepass\RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString();
    exit(1);
}catch (Exception $e){
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString();
    exit(1);
}


$result = $factory->produce()->run();
exit($result);