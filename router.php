<?php
// htfaker - router.php v0.0.1

$debug = true;

require 'vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker($debug);

return $htfaker->run();
