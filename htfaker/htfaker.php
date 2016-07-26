<?php
// htfaker - Htfaker class v0.0.1

namespace Attogram\Htfaker;

use Tivie\HtaccessParser\Parser;

class Htfaker
{
    const HTFAKER_VERSION = '0.0.1';
    const HTACCESS_FILE = '.htaccess';

    public $debug = true;
    public $htaccessFiles;
    public $parser;

    /**
     * start htfaker
     * @param bool $debug (optional)
     */
    public function __construct($debug = true)
    {
        $this->debug = $debug;
        $this->debug('HTFAKER_VERSION: v'.self::HTFAKER_VERSION);
        $this->debug('HTACCESS_FILE: '.self::HTACCESS_FILE);
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
        $this->htaccessFiles[self::HTACCESS_FILE] = null;
        $this->htaccessFiles['../'.self::HTACCESS_FILE] = null;
        $this->htaccessFiles['../../'.self::HTACCESS_FILE] = null;
        $this->htaccessFiles['TODO: travel up to WEBROOT, get each '.self::HTACCESS_FILE.' file']  = null;
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
                $this->debug('parseHtaccessFiles: NOT FILE/NOT READABLE: '.$file);
                continue;
            }
            $this->htaccessFiles[$file] = $this->getParser()->parse(new \SplFileObject($file));
            $this->debug('parseHtaccessFiles: parsed OK: '.$file);
        }
    }

    /**
     * Apply all the applicable htaccess rules for this request
     * @see Htfaker::$htaccessFiles
     */
    public function applyHtaccess()
    {
        //
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
        return $this->parser = new Parser();
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
        echo '<pre style="background-color:#ffffaa;margin:0;">DEBUG: '
            .print_r($message, true).'</pre>';
    }
}
