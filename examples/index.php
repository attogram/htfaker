<?php
// htfaker - example

require __DIR__.'/../vendor/autoload.php';

$htfaker = new \Attogram\htfaker\htfaker();

echo '<html><head><title>htfaker example</title></head><body><pre>',
  '<strong>htfaker example</strong><br /><br />',
  print_r($htfaker, true),
  '</pre></body></html>';
