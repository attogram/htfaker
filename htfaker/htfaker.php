<?php
// htfaker - htfaker class v0.0.1

namespace Attogram\htfaker;

use Tivie\HtaccessParser\Parser;

class htfaker
{
    const HTFAKER_VERSION = '0.0.1';

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
        $this->getHtaccessFiles();
        $this->parseHtaccessFiles();
    }

    public function getHtaccessFiles()
    {
        $this->htaccessFiles['.htaccess'] = '';
        $this->htaccessFiles['TODO: travel up to WEBROOT, get each .htaccess file']  = '';
    }

    public function parseHtaccessFiles()
    {
        foreach (array_keys($this->htaccessFiles) as $file) {
            if (!is_readable($file) || !is_file($file)) {
                continue;
            }
            $this->htaccessFiles[$file] = $this->getParser()->parse(new \SplFileObject($file));
        }
    }

    /**
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
     * @param string $htaccessFile
     * @return array
     */
    function getHtaccessFile($htaccessFile)
    {
        if (!is_file($htaccessFile) || !is_readable($htaccessFile)) {
            return array();
        }
        return $this->getParser()->parse(new \SplFileObject($htaccessFile));
    }

    /**
     * debug message
     * @param mixed $message (optional)
     */
    public function debug($message = '')
    {
        if (!$this->debug) {
            return;
        }
        echo '<pre>DEBUG: ' . print_r($message, true) . '</pre>';
    }
}
