<?php
// htfaker - example/alpha

require __DIR__.'/../../vendor/autoload.php';

$htfaker = new \Attogram\htfaker\htfaker();

echo '<html><head><title>htfaker example/alpha</title></head><body><pre>',
  '<strong>htfaker example/alpha</strong><br /><br />',
  print_r($htfaker, true),
  '</pre></body></html>';
