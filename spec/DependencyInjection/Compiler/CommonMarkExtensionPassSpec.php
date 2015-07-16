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
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * @mixin CompilerPassInterface
 */
class CommonMarkExtensionPassSpec extends ObjectBehavior
{
    const SERVICE_ENV = 'webuni_commonmark.default_environment';
    const EXTENSION_TAG = 'webuni_commonmark.extension';

    public function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass');
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function it_should_not_register_extension_if_extension_is_not_loaded($container)
    {
        $container->hasDefinition(self::SERVICE_ENV)->willReturn(false);
        $container->getDefinition(self::SERVICE_ENV)->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param Symfony\Component\DependencyInjection\Definition       $definition
     */
    public function it_should_register_extension($container, $definition)
    {
        $container->hasDefinition(self::SERVICE_ENV)->willReturn(true);
        $container->getDefinition(self::SERVICE_ENV)->willReturn($definition);
        $container->findTaggedServiceIds(self::EXTENSION_TAG)->willReturn(['my_service' => []]);

        $definition->addMethodCall('addExtension', Argument::containing(Argument::type('Symfony\Component\DependencyInjection\Reference')))->shouldBeCalled();

        $this->process($container);
    }
}
