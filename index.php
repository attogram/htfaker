<?php
// htfaker

namespace Attogram\htfaker;

define('', '0.0.1');

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/htfaker/htfaker.php';

$htfaker = new htfaker();

$testFile = $htfaker->getHtaccessFile('tests/.htaccess');

$errorDocument = $testFile->search('ErrorDocument');
$options = $testFile->search('Options');
$modRewrite = $testFile->search('modRewrite');

$cr = "\n";

echo '<pre>htfaker ', htfaker::HTFAKER_VERSION, $cr;
echo $cr, '(string)$testFile:', $cr, (string)$testFile;
echo $cr, '$testFile:', $cr, print_r($testFile, true);
echo $cr, '$errorDocument: ', print_r($errorDocument, true);
echo $cr, '$options: ', print_r($options, true);
echo $cr, 'modRewrite: ', print_r($modRewrite, true);
