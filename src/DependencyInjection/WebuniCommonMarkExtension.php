<?php

/*
 * This is part of the webuni/commonmark-bundle package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\Bundle\CommonMarkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class WebuniCommonMarkExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $converters = [];
        foreach ($mergedConfig['converters'] as $name => $config) {
            $environment = new DefinitionDecorator($config['environment']);
            $environment->setClass($container->getDefinition($config['environment'])->getClass());
            $environment->addMethodCall('mergeConfig', [$config['config']]);
            $environment->addTag('webuni_commonmark.environment_extensions', $config['extensions']);

            $parser = new DefinitionDecorator($config['parser']);
            $parser->setClass($container->getDefinition($config['parser'])->getClass());
            $parser->replaceArgument(0, $environment);

            $renderer = new DefinitionDecorator($config['renderer']);
            $renderer->setClass($container->getDefinition($config['renderer'])->getClass());
            $renderer->replaceArgument(0, $environment);

            $converter = new DefinitionDecorator($config['converter']);
            $converter->setClass($container->getDefinition($config['converter'])->getClass());
            $converter->replaceArgument(0, $parser);
            $converter->replaceArgument(1, $renderer);

            $converters[$name] = $converter;
        }

        $registry = $container->getDefinition('webuni_commonmark.converter_registry');
        $registry->replaceArgument(0, $converters);
    }

    public function getAlias()
    {
        return 'webuni_commonmark';
    }
}
