<?php

namespace Attogram\Htfaker;

use Tivie\HtaccessParser\Parser;

class Htfaker
{
    const HTFAKER_VERSION = '0.0.1';
    const HTACCESS_FILE = '.htaccess';

    public $debug;
    public $htaccessFiles;
    public $parser;

    /**
     * start htfaker
     * @param  bool $debug (optional) Debug messages on/off
     */
    public function __construct($debug = false)
    {
        $this->debug = $debug;
        $this->debug('htfaker v'.self::HTFAKER_VERSION);
    }

    /**
     * run htfaker
     * @return bool  true: handle current request
     *               false: pass control back to server
     */
    public function run()
    {
        $this->setHtaccessFiles();
        if (!$this->htaccessFiles) {
            $this->debug('No '.self::HTACCESS_FILE.' files found. returning false.');
            return false; // send request back to server
        }
        $this->debug(
            'htaccessFiles: '.count($this->htaccessFiles)
            //.'<br />'.implode('<br />', array_keys($this->htaccessFiles))
        );
        $this->parseHtaccessFiles();
        $this->applyHtaccess();
        $this->debug('end. IN DEV: returning false.');
        return false; // send request back to server
    }

    /**
     * set a list of readable .htaccess files for this request
     * in format:  htaccessFiles[ path_and_filename ] = true
     * @see Htfaker::$htaccessFiles
     */
    public function setHtaccessFiles()
    {
        $currentDirectory = dirname(realpath($_SERVER['SCRIPT_FILENAME']));
        $file = $currentDirectory.DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
        if (is_file($file) && is_readable($file)) {
            $this->htaccessFiles[$file] = true;
        }
        $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
        if ($currentDirectory == $documentRoot) {
            return;
        }
        $levels = str_replace($documentRoot, '', $currentDirectory);
        $levelsCount = sizeof(explode(DIRECTORY_SEPARATOR, $levels));
        if ($levelsCount == 0) {
            return;
        }
        $rel = '';
        for ($x = 0; $x <= $levelsCount; $x++ ) {
            $file = realpath($currentDirectory.$rel)
                .DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
            if (is_file($file) && is_readable($file)) {
                $this->htaccessFiles[$file] = true;
            }
            $rel .= '..'.DIRECTORY_SEPARATOR;
        }
    }

    /**
     * parse all files in the htaccessFiles list
     * @see Htfaker::$htaccessFiles
     */
    public function parseHtaccessFiles()
    {
        foreach (array_keys($this->htaccessFiles) as $file) {
            $this->htaccessFiles[$file] = $this->getParser()->parse(
                new \SplFileObject($file)
            );
        }
    }

    /**
     * Apply all the applicable htaccess rules for this request
     * @see Htfaker::$htaccessFiles
     */
    public function applyHtaccess()
    {
        foreach ($this->htaccessFiles as $file => $contents) {
            if (!is_object($contents)) {
                //$this->debug('applyHtaccess: NOT FOUND: '.$file);
                continue;
            }
            $this->debug();
            $this->debug(
                'applyHtaccess: '.$file.'<br />'
                .'<span style="color:#999999;font-size:small;">'
                .(string)$contents.'</span>'
            );
        }
    }

    /**
     * get the .htaccess parser object
     * @see Htfaker:$parser
     * @return object
     */
    public function getParser()
    {
        if (is_object($this->parser)) {
            return $this->parser;
        }
        $this->parser = new Parser();
        $this->parser->ignoreWhiteLines(true);
        $this->parser->ignoreComments(true);
        return $this->parser;
    }

    /**
     * debug message
     * @param mixed $message (optional)
     * @see Htfaker::$debug
     */
    public function debug($message = '')
    {
        if (!$this->debug) {
            return;
        }
        echo '<pre style="background-color:#ffffaa;margin:0;">'
            .print_r($message, true)
            .'</pre>';
    }
}
