<?php
// htfaker - examples/alpha/

$baseDir = dirname('../../../');

//$baseDir.'/vendor/autoload.php';
//$htfaker = new \Attogram\Htfaker\Htfaker(true);

echo '<a href="'.$baseDir.'">htfaker</a> / ',
    '<a href="'.$baseDir.'/examples/">examples</a> / ',
    '<strong>alpha</strong> / ',
    '<a href="'.$baseDir.'/examples/alpha/beta/">beta</a> / ',
    '<a href="'.$baseDir.'/examples/alpha/beta/gamma/">gamma</a> /';

    echo '<pre>_SERVER: '.print_r($_SERVER, true).'</pre>';
