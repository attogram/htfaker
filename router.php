<?php
// htfaker - router.php

$debug = true;

require 'vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker($debug);

return $htfaker->run();
