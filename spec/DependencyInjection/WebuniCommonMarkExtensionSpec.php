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
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass;
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
        expect($converters)->shouldHaveCount(1);
        expect($converters)->shouldHaveKey('default');
    }

    public function it_should_compile_default_converter_and_add_default_extensions()
    {
        $builder = new ContainerBuilder();
        $builder->addCompilerPass(new CommonMarkExtensionPass());

        $this->load([], $builder);
        $builder->compile();

        $serviceIds = $builder->getServiceIds();
        $expectedServiceIds = ['webuni_commonmark.converter_registry', 'webuni_commonmark.default_converter', 'service_container'];
        sort($serviceIds);
        sort($expectedServiceIds);
        expect($serviceIds)->shouldBe($expectedServiceIds);

        $environment = $builder->getDefinition('webuni_commonmark.default_converter')->getArgument(0)->getArgument(0);
        $calls = $environment->getMethodCalls();
        expect($calls)->shouldHaveCount(3);
        expect($calls[0][0])->shouldBe('addExtension');
        expect($calls[1][0])->shouldBe('addExtension');
        expect($calls[2][0])->shouldBe('mergeConfig');
    }
}
