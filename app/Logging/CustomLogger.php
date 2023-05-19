<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class CustomLogger
{
    public function __invoke(array $config)
    {
        $handler = new StreamHandler($config['path'], $config['level']);
        $handler->setFormatter(new LineFormatter(null, null, true, true));
        return new Logger('custom', [$handler]);
    }
}
