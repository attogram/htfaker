<?php

namespace Attogram\Htfaker;

class DirectoryIndex implements DirectiveInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $directives List of directives
     * @return mixed
     */
    public function apply(
        \Symfony\Component\HttpFoundation\Request $request,
        array $directives
    ) {
        return '[IN DEV: '.implode(', ', $directives).']';
    }

}
