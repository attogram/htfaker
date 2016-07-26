<?php
// htfaker - Htfaker class v0.0.1

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
     * @param bool $debug (optional)
     */
    public function __construct($debug = false)
    {
        $this->debug = $debug;
        $this->debug('HTFAKER_VERSION: v'.self::HTFAKER_VERSION);
        //$this->debug('HTACCESS_FILE: '.self::HTACCESS_FILE);
        $this->setHtaccessFiles();
        $this->parseHtaccessFiles();
        $this->applyHtaccess();
        //$this->debug('Htfaker Object: '.print_r($this, true));
    }

    /**
     * set a list of .htaccess files for this request
     * @see Htfaker::$htaccessFiles
     */
    public function setHtaccessFiles()
    {
        $this->htaccessFiles[realpath('.').DIRECTORY_SEPARATOR.self::HTACCESS_FILE] = null;

        $currentDirectory = dirname(realpath($_SERVER['SCRIPT_FILENAME']));
        $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
        $this->debug('currentDirectory: '.$currentDirectory);
        $this->debug('documentRoot: '.$documentRoot);

        if ($currentDirectory == $documentRoot) {
            $this->debug('setHtaccessFiles: '.print_r($this->htaccessFiles, true));
            return;
        }

        $levels = str_replace($documentRoot, '', $currentDirectory);
        $levelsCount = sizeof(explode(DIRECTORY_SEPARATOR, $levels));
        if ($levelsCount == 0) {
            $this->debug('setHtaccessFiles: '.print_r($this->htaccessFiles, true));
            return;
        }

        $rel = '';
        for ($x = 0; $x < $levelsCount; $x++ ) {
            $this->htaccessFiles[realpath($rel).DIRECTORY_SEPARATOR.self::HTACCESS_FILE] = null;
            $rel .= '../';
        }

        $this->debug('setHtaccessFiles: '.print_r($this->htaccessFiles, true));
    }

    /**
     * parse all files in the htaccessFiles list
     * @see Htfaker::$htaccessFiles
     */
    public function parseHtaccessFiles()
    {
        foreach (array_keys($this->htaccessFiles) as $file) {
            if (!is_readable($file) || !is_file($file)) {
                //$this->debug('parseHtaccessFiles: NOT FOUND: '.$file);
                continue;
            }
            $this->htaccessFiles[$file] = $this->getParser()->parse(new \SplFileObject($file));
            //$this->debug('parseHtaccessFiles: OK: '.$file);
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
                $this->debug('applyHtaccess: NOT FOUND: '.$file);
                continue;
            }
            $this->debug('applyHtaccess: '.$file);
            $this->debug((string)$contents.'<br />');
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
