<?php
// htfaker - example

require __DIR__.'/../../../vendor/autoload.php';

$htfaker = new \Attogram\htfaker\htfaker();

echo '<html><head><title>htfaker example/alpha/beta</title></head><body><pre>',
  '<strong>htfaker example alpha/beta</strong><br /><br />',
  print_r($htfaker, true),
  '</pre></body></html>';
