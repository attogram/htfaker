<?php

namespace Attogram\Htfaker;

class Directive implements DirectiveInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $directives List of directives
     * @return mixed
     */
    public function apply(
        \Attogram\Htfaker\Router $htfaker,
        array $directives
    ) {
        $htfaker->log->info(get_class($this).'::apply:', $directives);
        return false;
    }

}
