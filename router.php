<?php
/**
 * htfaker - router.php
 */

namespace Attogram\Htfaker;

use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

$htfaker = new Router(Request::createFromGlobals());

if (!$htfaker->run()) {
    // If this script returns FALSE, then the requested resource is returned as-is.
    // Otherwise the script's output is returned to the browser.
    return false;
}
