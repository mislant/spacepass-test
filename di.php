<?php

use Spacepass\Input;
use Spacepass\Parser;
use Spacepass\Worker;

return [
    \Psr\Log\LoggerInterface::class => \DI\create(\Symfony\Component\Console\Logger\ConsoleLogger::class)
        ->constructor(
            \DI\create(\Symfony\Component\Console\Output\ConsoleOutput::class)->constructor(
                \Symfony\Component\Console\Output\ConsoleOutput::VERBOSITY_VERY_VERBOSE
            )
        ),
    Input::class => \DI\create(\Spacepass\Simple\InputImplementation::class)
        ->constructor(__DIR__ . '/config.yaml'),
    Parser::class => \DI\create(\Spacepass\Simple\ParserImplementation::class),
    Worker::class => \DI\create(\Spacepass\Simple\WorkerImplementation::class)
        ->constructor(\DI\get(\Psr\Log\LoggerInterface::class)),

];