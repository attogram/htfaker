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
    public $apply;

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
            $this->debug('No '.self::HTACCESS_FILE.' files found. RETURN FALSE');
            return false; // send request back to server
        }
        //$this->debug(
            //'htaccessFiles: '.count($this->htaccessFiles)
            //.'<br />'.implode('<br />', array_keys($this->htaccessFiles))
        //);
        $this->parseHtaccessFiles();
        $this->applyHtaccess();
        $this->debug('End. IN DEV: RETURN FALSE');
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
                $this->debug('applyHtaccess: ERROR: '.$file);
                continue;
            }
            $this->debug('applyHtaccess: '.$file);

            if ($options = $contents->search('Options')) {
                $this->apply['Options'][] = (string)$options;
                //$this->debug('- Options: '.$options);
            }
            if ($fallbackResource = $contents->search('FallbackResource')) {
                $this->apply['FallbackResource'][] = (string)$fallbackResource;
                //$this->debug('- FallbackResource: '.$fallbackResource);
            }
            if ($errorDocument = $contents->search('ErrorDocument')) {
                $this->apply['ErrorDocument'][] = (string)$errorDocument;
                //$this->debug('- ErrorDocument: '.$errorDocument);
            }
            if ($directoryIndex = $contents->search('DirectoryIndex')) {
                $this->apply['DirectoryIndex'][] = (string)$directoryIndex;
                //$this->debug('- DirectoryIndex: '.$directoryIndex);
            }
            if ($modRewrite = $contents->search('modRewrite')) {
                $this->apply['modRewrite'][] = (string)$modRewrite;
                //$this->debug('- modRewrite: '.$modRewrite);
            }
        }
        $this->debug('applyHtaccess: apply: '.print_r($this->apply, true));
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
