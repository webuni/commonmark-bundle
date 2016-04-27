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
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;
use Webuni\CommonMark\TableExtension\TableExtension;

class WebuniCommonMarkExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($mergedConfig['extensions']['attributes'] && class_exists(AttributesExtension::class)) {
            $loader->load('extensions/attributes.xml');
        }

        if ($mergedConfig['extensions']['table'] && class_exists(TableExtension::class)) {
            $loader->load('extensions/table.xml');
        }

        $converters = [];
        foreach ($mergedConfig['converters'] as $name => $config) {
            $converters[$name] = new Reference($this->createConverter($name, $config, $container));
        }

        $registry = $container->getDefinition('webuni_commonmark.converter_registry');
        $registry->replaceArgument(0, $converters);
    }

    public function getAlias()
    {
        return 'webuni_commonmark';
    }

    private function createConverter($name, array $config, ContainerBuilder $container)
    {
        $environment = new DefinitionDecorator($config['environment']);
        $environment->setPublic(false);
        $environment->setClass($container->getDefinition($config['environment'])->getClass());
        $environment->addMethodCall('mergeConfig', [$config['config']]);
        $environment->addTag('webuni_commonmark.environment.extensions', $config['extensions']);
        // $environment->addTag('webuni_commonmark.environment', ['parent' => $config['environment'], 'extensions' => [$config['extensions']]);

        $environmentName = 'webuni_commonmark.'.$name.'_environment'.$config['environment'];
        $container->setDefinition($environmentName, $environment);

        $parser = new DefinitionDecorator($config['parser']);
        $parser->setPublic(false);
        $parser->setClass($container->getDefinition($config['parser'])->getClass());
        $parser->replaceArgument(0, new Reference($environmentName));

        $renderer = new DefinitionDecorator($config['renderer']);
        $renderer->setPublic(false);
        $renderer->setClass($container->getDefinition($config['renderer'])->getClass());
        $renderer->replaceArgument(0, new Reference($environmentName));

        $converter = new DefinitionDecorator($config['converter']);
        $converter->setPublic(true);
        $converter->setClass($container->getDefinition($config['converter'])->getClass());
        $converter->replaceArgument(0, $parser);
        $converter->replaceArgument(1, $renderer);

        $converterName = 'webuni_commonmark.'.$name.'_converter';
        $container->setDefinition($converterName, $converter);

        return $converterName;
    }
}
