<?php
// htfaker

namespace Attogram\htfaker;

define('', '0.0.1');

require __DIR__.'/vendor/autoload.php';

$htfaker = new htfaker();
$testFile = $htfaker->getHtaccessFile('tests/.htaccess');
$errorDocument = $testFile->search('ErrorDocument');
$options = $testFile->search('Options');
$modRewrite = $testFile->search('modRewrite');

$cr = "\n";

echo '<pre>htfaker ', htfaker::HTFAKER_VERSION,
    ' - ', date('Y-m-d h:i:s'), ' - ',
    ' https://github.com/attogram/htfaker', $cr,
    $cr, '(string)$testFile:', $cr, (string)$testFile,
    $cr, '$testFile:', $cr, print_r($testFile, true),
    $cr, '$errorDocument: ', print_r($errorDocument, true),
    $cr, '$options: ', print_r($options, true),
    $cr, '$modRewrite: ', print_r($modRewrite, true);
