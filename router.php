<?php
// htfaker - router.php

namespace Attogram\Htfaker;

use Symfony\Component\HttpFoundation\Request;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\BufferHandler;
use Monolog\Logger;

require 'vendor/autoload.php';

// Setup PSR-3 Logger object
$log = new Logger('debug');
$streamHandler = new StreamHandler('php://output');
$streamHandler->setFormatter(new LineFormatter(
    '<pre style="background-color:#ffffaa;margin:0;">%datetime%|%level_name%: %message% %context%</pre>', // %extra%
    'Y-m-d|H:i:s:u'
));
//$log->pushHandler(new BufferHandler($streamHandler));
$log->pushHandler($streamHandler);

$htfaker = new \Attogram\Htfaker\Router(
  Request::createFromGlobals(),
  $log,
  true // debug
);

// "If this script returns FALSE, then the requested resource is returned as-is.
// Otherwise the script's output is returned to the browser."
if (!$htfaker->run()) {
    return false;
}
