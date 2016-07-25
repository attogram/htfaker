<?php
// htfaker - htfaker class v0.0.1

namespace Attogram\htfaker;

use Tivie\HtaccessParser\Parser;

class htfaker
{
    const HTFAKER_VERSION = '0.0.1';

    public $parser;

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
}
