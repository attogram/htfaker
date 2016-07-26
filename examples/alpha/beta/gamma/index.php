<?php
// htfaker - examples/alpha/beta/gamma/

$baseDir = dirname('../../../../../');

require $baseDir.'/vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker();

echo '<a href="'.$baseDir.'">htfaker</a> / ',
    '<a href="'.$baseDir.'/examples/">examples</a> / ',
    '<a href="'.$baseDir.'/examples/alpha/">alpha</a> / ',
    '<a href="'.$baseDir.'/examples/alpha/beta/">beta</a> / ',
    '<strong>gamma</strong> /';
