<?php

namespace DependencyInjection\TheCodeine\EditorBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TheCodeineEditorExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TheCodeine\EditorBundle\DependencyInjection\TheCodeineEditorExtension');
    }
}