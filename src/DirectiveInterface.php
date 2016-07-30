<?php

namespace Attogram\Htfaker;

interface DirectiveInterface
{
    /**
     * @param \Attogram\Htfaker\Router $htfaker
     * @param array $directives List of directives to apply
     * @return mixed
     */
    public function apply(
        \Attogram\Htfaker\Router $htfaker,
        array $directives
    );
}
