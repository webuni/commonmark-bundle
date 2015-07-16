<?php

/*
 * This is part of the webuni/commonmark-bundle package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Webuni\Bundle\CommonMarkBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webuni\Bundle\CommonMarkBundle\DependencyInjection\WebuniCommonMarkExtension;

/**
 * @mixin WebuniCommonMarkExtension
 */
class WebuniCommonMarkExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\DependencyInjection\WebuniCommonMarkExtension');
    }

    public function it_should_have_correct_name()
    {
        $this->getAlias()->shouldBe('webuni_commonmark');
    }

    public function it_should_create_default_converter()
    {
        $builder = new ContainerBuilder();

        $this->load([], $builder);

        $converters = $builder->getDefinition('webuni_commonmark.converter_registry')->getArgument(0);
        expect($converters)->shouldHaveKey('default');
    }

    public function it_should_be_compilabl()
    {
        $builder = new ContainerBuilder();

        $this->load([], $builder);
        $builder->compile();
        var_dump($builder->get('webuni_commonmark.converter_registry'));
    }
}
