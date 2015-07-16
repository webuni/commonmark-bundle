<?php

/*
 * This is part of the webuni/commonmark-bundle package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommonMarkExtensionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('webuni_commonmark.default_environment')) {
            return;
        }

        $definition = $container->getDefinition('webuni_commonmark.default_environment');
        foreach ($container->findTaggedServiceIds('webuni_commonmark.extension') as $id => $tag) {
            $alias = isset($tag[0]['alias']) ? $tag[0]['alias'] : $id;
            $definition->addMethodCall('addExtension', [new Reference($id), $alias]);
        }
    }
}
