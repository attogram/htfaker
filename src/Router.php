<?php

namespace Attogram\Htfaker;

use Tivie\HtaccessParser\Parser;

class Router
{
    const HTFAKER_VERSION = '0.0.2';
    const HTACCESS_FILE = '.htaccess';

    public $request;
    public $debug = false;
    public $htaccessFiles = array();
    public $parser;
    public $apply = array();
    public $directives = array(
        'Options',
        'FallbackResource',
        'ErrorDocument',
        'DirectoryIndex'
    );
    public $indexi = array(
        'index.php',
        'index.html'
    );
    public $isFile = false;
    public $isDir = false;

    /**
     * start htfaker router
     * @param obj $request \Symfony\Component\HttpFoundation\Request object
     * @param bool $debug (optional) Debug messages on/off
     */
    public function __construct(
        \Symfony\Component\HttpFoundation\Request $request,
        $debug = false
    ) {
        $this->request = $request;
        $this->debug = $debug;
        $this->debug('htfaker v'.self::HTFAKER_VERSION.' @ '.gmdate('Y-m-d h:i:s'));
    }

    /**
     * run htfaker router
     * @return bool  true: handle current request
     *               false: pass control back to server
     */
    public function run()
    {
        //$this->debug('run: server: '.print_r($this->request->server, true));
        $this->setHtaccessFiles(); // get all .htaccess files
        if (!$this->htaccessFiles) { // No .htaccess files found
            $this->debug('No '.self::HTACCESS_FILE.' files found. return false');
            return false; // send request back to server
        }
        $this->parseHtaccessFiles();
        $this->checkRequest();
        $this->applyHtaccess();
        $this->debug('IN DEV. return false');
        return false; // send request back to server
    }

    /**
     * set a list of readable .htaccess files for this request
     * in format:  htaccessFiles[ path_and_filename ] = true
     * @see Htfaker::$htaccessFiles
     */
    public function setHtaccessFiles()
    {
        $documentRoot = $this->request->server->get('DOCUMENT_ROOT');
        $this->debug('documentRoot: '.$documentRoot);
        $currentDirectory = dirname($this->request->server->get('SCRIPT_FILENAME'));
        $this->debug('currentDirectory: '.$currentDirectory);
        $file = $currentDirectory.DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
        if (is_file($file) && is_readable($file)) {
            $this->htaccessFiles[$file] = true;
            $this->debug('LOADING: '.$file);
        } else {
            $this->debug('missing: '.$file);
        }
        if ($currentDirectory == $documentRoot) {
            return;
        }
        $levels = str_replace($documentRoot, '', $currentDirectory);
        $levelsCount = sizeof(explode(DIRECTORY_SEPARATOR, $levels)) - 2;
        $rel = '..';
        for ($x = 0; $x <= $levelsCount; $x++ ) {
            $rel .= DIRECTORY_SEPARATOR.'..';
            $file = realpath($currentDirectory.$rel).DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
            if (is_file($file) && is_readable($file)) {
                $this->htaccessFiles[$file] = true;
                $this->debug('LOADING: '.$file);
            } else {
                $this->debug('missing: '.$file);
            }
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
     *
     */
    public function checkRequest()
    {
        //$this->debug('getUri: '.$this->request->getUri());
        //$this->debug('getRequestUri: '.$this->request->getRequestUri());
        //$this->debug('getBaseUrl: '.$this->request->getBaseUrl());
        //$this->debug('getBasePath: '.$this->request->getBasePath());
        //$this->debug('getPathInfo: '.$this->request->getPathInfo());
        //$this->debug('getScriptName: '.$this->request->getScriptName());
        //$this->debug('server: '.print_r($this->request->server, true));

        $uri = '.'.$this->request->getScriptName();
        $this->debug('uri: '.$uri);

        if (is_file($uri)) {
            $this->isFile = $uri;
            //$this->debug('+ IS FILE');
        } else {
            //$this->debug('- not file');
        }
        if (is_dir($uri)) {
            //$this->debug('+ IS DIR');
            $this->isDir = $uri;
            foreach ($this->indexi as $index) {
                if (is_file($uri.DIRECTORY_SEPARATOR.$index)) {
                    $this->isFile = $uri.DIRECTORY_SEPARATOR.$index;
                    //$this->debug('+ DIR HAS '.$index);
                    break;
                } else {
                    //$this->debug('- not has '.$index);
                }
            }
        } else {
            //$this->debug('- not dir');
        }
        $this->debug('isFile: '.$this->isFile);
        $this->debug('isDir: '.$this->isDir);
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
            //$this->debug('applyHtaccess: '.$file);
            foreach ($this->directives as $directive) {
                if ($result = $contents->search($directive)) {
                    $this->apply[$directive][] = (string)$result;
                }
            }
        }
        //$this->debug('apply directives: '.print_r($this->apply, true));
        $namespace = 'Attogram\\Htfaker\\';
        foreach (array_keys($this->apply) as $directive) {
            $className = $namespace.$directive;
            if (class_exists($className)) {
                //$this->debug('CLASS EXISTS: '.$className);
                $class = new $className();
                $result = $class->apply($this, $this->apply[$directive]);
                $this->debug($directive.': '.print_r($result, true));
            } else {
                $this->debug('ERROR: directive class not found: '.$className);
            }
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
            ."\n"
            .print_r($message, true)
            ."\n"
            .'</pre>';
    }
}
