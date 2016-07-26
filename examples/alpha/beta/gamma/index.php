<?php
// htfaker - example

require __DIR__.'/../../../../vendor/autoload.php';

$htfaker = new \Attogram\htfaker\htfaker();

echo '<html><head><title>htfaker example alpha/beta/gamma</title></head><body><pre>',
  '<strong>htfaker example alpha/beta/gamma</strong><br /><br />',
  print_r($htfaker, true),
  '</pre></body></html>';
