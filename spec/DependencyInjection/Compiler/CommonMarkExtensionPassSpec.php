<?php

/*
 * This is part of the webuni/commonmark-bundle package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass;

/**
 * @mixin CommonMarkExtensionPass
 */
class CommonMarkExtensionPassSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass');
    }

    public function it_should_register_extension(ContainerBuilder $container, Definition $definition)
    {
        $container->getDefinition('webuni_commonmark.default_environment')->willReturn($definition);
        $container->findTaggedServiceIds('webuni_commonmark.extension')->willReturn(['my_service' => []]);
        $container->findTaggedServiceIds('webuni_commonmark.environment.extensions')->willReturn([]);
        $container->hasDefinition('webuni_commonmark.default_environment')->willReturn(true);

        $definition->addMethodCall('addExtension', Argument::containing(Argument::type('Symfony\Component\DependencyInjection\Reference')))->shouldBeCalled();

        $this->process($container);
    }
}
