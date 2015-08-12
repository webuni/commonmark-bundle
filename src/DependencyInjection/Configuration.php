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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder->root('webuni_commonmark', 'array')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('default_converter')->defaultValue('default')->end()
                ->arrayNode('extensions')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('attributes')->defaultTrue()->end()
                        ->booleanNode('table')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('converters')
                    ->defaultValue(['default' => [
                        'converter'   => 'webuni_commonmark.converter',
                        'environment' => 'webuni_commonmark.default_environment',
                        'parser'      => 'webuni_commonmark.docparser',
                        'renderer'    => 'webuni_commonmark.htmlrenderer',
                        'config'      => [],
                        'extensions'  => [],
                    ]])
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($v) {
                            return array_merge(['default' => null], $v);
                        })
                    ->end()
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('converter')->defaultValue('webuni_commonmark.converter')->end()
                            ->scalarNode('environment')->defaultValue('webuni_commonmark.default_environment')->end()
                            ->scalarNode('parser')->defaultValue('webuni_commonmark.docparser')->end()
                            ->scalarNode('renderer')->defaultValue('webuni_commonmark.htmlrenderer')->end()
                            ->arrayNode('config')
                                ->prototype('variable')
                                    ->defaultValue([])
                                ->end()
                            ->end()
                            ->arrayNode('extensions')
                                ->defaultValue([])
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
