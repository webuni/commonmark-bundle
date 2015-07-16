<?php

namespace spec\Webuni\Bundle\CommonMarkBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConverterRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\ConverterRegistry');
    }
}
