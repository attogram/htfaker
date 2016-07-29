<?php
// htfaker - router.php

namespace Attogram\Htfaker;

use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker(
  Request::createFromGlobals(),
  true // debug
);

// "If this script returns FALSE, then the requested resource is returned as-is.
// Otherwise the script's output is returned to the browser."
if( !$htfaker->run() ) {
    return false;
}
