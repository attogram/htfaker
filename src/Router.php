<?php

namespace Attogram\Htfaker;

use Tivie\HtaccessParser\Parser;

class Router
{
    const HTFAKER_VERSION = '0.0.2';
    const HTACCESS_FILE = '.htaccess';

    /** @var Symfony\Component\HttpFoundation\Request The Request object */
    public $request;
    /** @var bool Debug on/off */
    public $debug = false;
    /** @var string The Document Root of current request */
    public $documentRoot;
    /** @var string The Current Directory of current request */
    public $currentDirectory;
    /** @var array List of all .htaccess files that can be applied to current request */
    public $htaccessFiles = array();
    /** @var Tivie\HtaccessParser\Parser .htacces parser */
    public $parser;
    /** @var array List of .htaccess directives to be applied to current request */
    public $apply = array();
    /** @var array List of .htaccess directives that can be parsed */
    public $directives = array(
        'Options',
        'FallbackResource',
        'ErrorDocument',
        'DirectoryIndex'
    );
    /** @var array List of default index filenames */
    public $indexi = array('index.php', 'index.html');
    /** @var string The filename of the request */
    public $file;
    /** @var string The directory of the request */
    public $directory;

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
        $this->debug('htfaker v'.self::HTFAKER_VERSION.' @ '.gmdate('Y-m-d h:i:s').' UTC');
    }

    /**
     * run htfaker router
     * @return bool  true: handle current request
     *               false: pass control back to server
     */
    public function run()
    {
        //$this->debug('getUri: '.$this->request->getUri());
        //$this->debug('getRequestUri: '.$this->request->getRequestUri());
        //$this->debug('getBaseUrl: '.$this->request->getBaseUrl());
        //$this->debug('getBasePath: '.$this->request->getBasePath());
        //$this->debug('getPathInfo: '.$this->request->getPathInfo());
        //$this->debug('getScriptName: '.$this->request->getScriptName());
        //$this->debug('server: '.print_r($this->request->server, true));
        //$this->debug('SCRIPT_FILENAME='.$this->request->server->get('SCRIPT_FILENAME'));

        $this->debug('documentRoot: '.$this->getDocumentRoot());
        $this->debug('currentDirectory: '.$this->getCurrentDirectory());
        $this->setHtaccessFiles(); // get all possible .htaccess files for this request
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
     * @see Router::$documentRoot
     * @return void
     */
    public function setDocumentRoot()
    {
        $this->documentRoot = $this->request->server->get('DOCUMENT_ROOT');
    }

    /**
     * @see Router::$documentRoot
     * @return string The Document Root of current request
     */
    public function getDocumentRoot()
    {
        if (!$this->documentRoot) {
            $this->setDocumentRoot();
        }
        return $this->documentRoot;
    }

    /**
     * @see Router::$currentDirectory
     * @return void
     */
    public function setCurrentDirectory()
    {
        $this->currentDirectory = realpath(dirname('.'.$this->request->getScriptName()));
    }

    /**
     * @see Router::$currentDirectory
     * @return string The Current Directory of current request
     */
    public function getCurrentDirectory()
    {
        if (!$this->currentDirectory) {
            $this->setCurrentDirectory();
        }
        return $this->currentDirectory;
    }

    /**
     * set a list of readable .htaccess files for this request
     * in format:  htaccessFiles[ path_and_filename ] = true
     * @see Router::$htaccessFiles
     */
    public function setHtaccessFiles()
    {
        $file = $this->getCurrentDirectory().DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
        if (is_file($file) && is_readable($file)) {
            $this->htaccessFiles[$file] = true; // .htaccess from current directory
            $this->debug('LOADING: '.$file);
        } else {
            $this->debug('missing: '.$file);
        }
        if ($this->getCurrentDirectory() == $this->getDocumentRoot()) {
            return;
        }
        $levels = str_replace($this->getDocumentRoot(), '', $this->getCurrentDirectory());
        $levelsCount = sizeof(explode(DIRECTORY_SEPARATOR, $levels)) - 2;
        $rel = '..';
        for ($x = 0; $x <= $levelsCount; $x++ ) {
            $rel .= DIRECTORY_SEPARATOR.'..';
            $file = realpath($this->getCurrentDirectory().$rel).DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
            if (is_file($file) && is_readable($file)) {
                $this->htaccessFiles[$file] = true; // .htaccess from higher directories
                $this->debug('LOADING: '.$file);
            } else {
                $this->debug('missing: '.$file);
            }
        }
    }

    /**
     * parse all files in the htaccessFiles list
     * @see Router::$htaccessFiles
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
        $uri = '.'.$this->request->getScriptName();
        $this->debug('uri: '.$uri);

        if (is_file($uri)) {
            $this->file = $uri;
            //$this->debug('+ IS FILE');
        } else {
            //$this->debug('- not file');
        }
        if (is_dir($uri)) {
            //$this->debug('+ IS DIR');
            $this->directory = $uri;
            foreach ($this->indexi as $index) {
                if (is_file($uri.DIRECTORY_SEPARATOR.$index)) {
                    $this->file = $uri.DIRECTORY_SEPARATOR.$index;
                    //$this->debug('+ DIR HAS '.$index);
                    break;
                } else {
                    //$this->debug('- not has '.$index);
                }
            }
        } else {
            //$this->debug('- not dir');
        }
        $this->debug('file: '.($this->file ? $this->file : 'null'));
        $this->debug('directory: '.($this->directory ? $this->directory : 'null'));
    }

    /**
     * Apply all the applicable htaccess rules for this request
     * @see Router::$htaccessFiles
     */
    public function applyHtaccess()
    {
        foreach ($this->htaccessFiles as $file => $contents) {
            if (!is_object($contents)) {
                $this->debug('applyHtaccess: ERROR: '.$file);
                continue;
            }
            // build a list of directives that may be applied
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
                $this->debug($directive.' result: '.print_r($result, true));
            } else {
                $this->debug('applyHtaccess: ERROR: directive class not found: '.$className);
            }
        }
    }

    /**
     * get the .htaccess parser object
     * @see Router::$parser
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
     * @see Router::$debug
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
