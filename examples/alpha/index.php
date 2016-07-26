<?php
// htfaker - examples/alpha/

$baseDir = dirname('../../../');

require $baseDir.'/vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker();

echo '<a href="'.$baseDir.'">htfaker</a>: ',
    '<a href="'.$baseDir.'/examples/">examples</a>/',
    '<strong>alpha</strong>/',
    '<a href="'.$baseDir.'/examples/alpha/beta/">beta</a>/',
    '<a href="'.$baseDir.'/examples/alpha/beta/gamma/">gamma</a>/';
