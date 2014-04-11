<?php
putenv('APP_DEBUG=1');
putenv('APP_MODE=test');

require __DIR__ . '/../src/vendors/autoload.php';

Herrera\Silex\Application::create()->run();
