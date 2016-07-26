<?php
// htfaker - examples/

$baseDir = dirname('../../');

require $baseDir.'/vendor/autoload.php';

$htfaker = new \Attogram\Htfaker\Htfaker(true);

echo '<a href="'.$baseDir.'">htfaker</a> / ',
    '<strong>examples</strong> / ',
    '<a href="'.$baseDir.'/examples/alpha/">alpha</a> / ',
    '<a href="'.$baseDir.'/examples/alpha/beta/">beta</a> / ',
    '<a href="'.$baseDir.'/examples/alpha/beta/gamma/">gamma</a> /';
