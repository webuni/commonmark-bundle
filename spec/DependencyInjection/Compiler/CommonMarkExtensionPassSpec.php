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

/**
 * @mixin \Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass
 */
class CommonMarkExtensionPassSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param \Symfony\Component\DependencyInjection\Definition       $definition
     */
    public function it_should_register_extension($container, $definition)
    {
        $container->getDefinition('webuni_commonmark.default_environment')->willReturn($definition);
        $container->findTaggedServiceIds('webuni_commonmark.extension')->willReturn(['my_service' => []]);
        $container->findTaggedServiceIds('webuni_commonmark.environment.extensions')->willReturn([]);
        $container->hasDefinition('webuni_commonmark.default_environment')->willReturn(true);

        $definition->addMethodCall('addExtension', Argument::containing(Argument::type('Symfony\Component\DependencyInjection\Reference')))->shouldBeCalled();

        $this->process($container);
    }
}
