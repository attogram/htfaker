<?php

namespace Attogram\Htfaker;

use Tivie\HtaccessParser\Parser;

class Router
{
    /** @var string */
    const HTFAKER_VERSION = '0.0.3';

    /** @var string */
    const HTACCESS_FILE = '.htaccess';

    /** @var bool verbose debug messages to STDOUT */
    public $verbose = true;

    /** @var Symfony\Component\HttpFoundation\Request The Request object */
    private $request;

    /** @var string The Document Root of current request */
    private $documentRoot;

    /** @var string The Current Directory of current request */
    private $currentDirectory;

    /** @var array List of all .htaccess files that can be applied to current request */
    private $htaccessFiles = [];

    /** @var Tivie\HtaccessParser\Parser .htacces parser */
    private $parser;

    /** @var array List of .htaccess directives to be applied to current request */
    private $apply = [];
    
    /** @var array List of .htaccess directives that can be parsed */
    private $directives = [
        'Options',
        'FallbackResource',
        'ErrorDocument',
        'DirectoryIndex',
    ];

    /** @var array List of default index filenames */
    private $indexi = [
        'index.php',
        'index.html',
    ];

    /** @var string The filename of the request */
    private $file;

    /** @var string The directory of the request */
    private $directory;

    /**
     * start htfaker router
     * @param obj $request \Symfony\Component\HttpFoundation\Request object
     * @param obj $log \Psr\Log\LoggerInterface PSR-3 Logger
     */
    public function __construct(\Symfony\Component\HttpFoundation\Request $request) {
        $this->request = $request;
        $this->verbose('htfaker v' . self::HTFAKER_VERSION);
    }

    /**
     * run htfaker router
     * @return bool  true: handle current request, false: pass control back to server
     */
    public function run()
    {
        $this->verbose('documentRoot: ' . $this->getDocumentRoot());
        $this->verbose('currentDirectory: ' . $this->getCurrentDirectory());
        $this->setHtaccessFiles(); // get all possible .htaccess files for this request
        if (!$this->htaccessFiles) { // No .htaccess files found
            $this->verbose('No ' . self::HTACCESS_FILE . ' files found. return false');
            return false; // send request back to server
        }
        $this->parseHtaccessFiles();
        $this->checkRequest();
        $this->applyHtaccess();
        $this->verbose('IN DEV. return false');
        return false; // send request back to server
    }

    /**
     * @see Router::$documentRoot
     * @return string The Document Root of current request
     */
    private function getDocumentRoot()
    {
        if (!$this->documentRoot) {
            $this->documentRoot = realpath($this->request->server->get('DOCUMENT_ROOT'));
        }
        return $this->documentRoot;
    }

    /**
     * @see Router::$currentDirectory
     * @return string The Current Directory of current request
     */
    private function getCurrentDirectory()
    {
        if (!$this->currentDirectory) {
            $this->currentDirectory = realpath(dirname('.' . $this->request->getScriptName()));
        }
        return $this->currentDirectory;
    }

    /**
     * set a list of readable .htaccess files for this request
     * in format:  htaccessFiles[ path_and_filename ] = true
     * @see Router::$htaccessFiles
     */
    private function setHtaccessFiles()
    {
        $file = $this->getCurrentDirectory().DIRECTORY_SEPARATOR.self::HTACCESS_FILE;
        if (is_file($file) && is_readable($file)) {
            $this->htaccessFiles[$file] = true; // .htaccess from current directory
            $this->verbose('LOADING: ' . $file);
        } else {
            $this->verbose('missing: ' . $file);
        }
        if ($this->getCurrentDirectory() == $this->getDocumentRoot()) {
            return;
        }
        $levels = str_replace($this->getDocumentRoot(), '', $this->getCurrentDirectory());
        $levelsCount = sizeof(explode(DIRECTORY_SEPARATOR, $levels)) - 2;
        $rel = '..';
        for ($x = 0; $x <= $levelsCount; $x++ ) {
            $rel .= DIRECTORY_SEPARATOR . '..';
            $file = realpath($this->getCurrentDirectory() . $rel) . DIRECTORY_SEPARATOR . self::HTACCESS_FILE;
            if (is_file($file) && is_readable($file)) {
                $this->htaccessFiles[$file] = true; // .htaccess from higher directories
                $this->verbose('LOADING: ' . $file);
            } else {
                $this->verbose('missing: ' . $file);
            }
        }
    }

    /**
     * parse all files in the htaccessFiles list
     * @see Router::$htaccessFiles
     */
    private function parseHtaccessFiles()
    {
        foreach (array_keys($this->htaccessFiles) as $file) {
            $this->htaccessFiles[$file] = $this->getParser()->parse(
                new \SplFileObject($file)
            );
        }
    }

    /**
     * @see Router::file
     * @see Router::directory
     */
    private function checkRequest()
    {
        $uri = '.' . $this->request->getScriptName();
        $this->verbose('uri: ' . $uri);

        if (is_file($uri)) {
            $this->file = $uri;
            //$this->verbose('+ IS FILE');
        }
        if (is_dir($uri)) {
            //$this->verbose('+ IS DIR');
            $this->directory = $uri;
            foreach ($this->indexi as $index) {
                if (is_file($uri . DIRECTORY_SEPARATOR.$index)) {
                    $this->file = $uri . DIRECTORY_SEPARATOR.$index;
                    //$this->verbose('+ DIR HAS '.$index);
                    break;
                }
            }
        }
        $this->verbose('file: ' . ($this->file ? $this->file : 'null'));
        $this->verbose('directory: ' . ($this->directory ? $this->directory : 'null'));
    }

    /**
     * Apply all the applicable htaccess rules for this request
     * @see Router::$htaccessFiles
     */
    private function applyHtaccess()
    {
        foreach ($this->htaccessFiles as $file => $contents) {
            if (!is_object($contents)) {
                $this->error('applyHtaccess: ERROR: ' . $file);
                continue;
            }
            // build a list of directives that may be applied
            foreach ($this->directives as $directive) {
                if ($result = $contents->search($directive)) {
                    $this->apply[$directive][] = $result;

                }
            }
        }
        $namespace = 'Attogram\\Htfaker\\';
        foreach (array_keys($this->apply) as $directive) {
            $className = $namespace.$directive;
            if (class_exists($className)) {
                $class = new $className();
                $result = $class->apply($this, $this->apply[$directive]);
                $this->verbose($directive . ' result: ' . print_r($result, true));
            } else {
                $this->error('applyHtaccess: ERROR: directive class not found: ' . $className);
            }
        }
    }

    /**
     * get the .htaccess parser object
     * @see Router::$parser
     * @return object
     */
    private function getParser()
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
     * @param mixed $message
     */
    private function verbose($message = '')
    {
        if ($this->verbose) {
            print 'DEBUG: ' . htmlentities(print_r($message, true)) . "<br />\n";
        }
    }

    /**
     * @param mixed $message
     */
    private function error($message = '')
    {
        print 'ERROR: ' . htmlentities(print_r($message, true)) . "<br />\n";
    }
}
