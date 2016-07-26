<?php
// htfaker - examples/alpha/beta/

$baseDir = dirname('../../../../');

require $baseDir.'/vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker();

echo '<a href="'.$baseDir.'">htfaker</a>: ',
    '<a href="'.$baseDir.'/examples/">examples</a>/',
    '<a href="'.$baseDir.'/examples/alpha/">alpha</a>/',
    '<strong>beta</strong>/',
    '<a href="'.$baseDir.'/examples/alpha/beta/gamma/">gamma</a>/';
