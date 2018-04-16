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
use Symfony\Component\Config\Definition\Processor;
use Webuni\Bundle\CommonMarkBundle\DependencyInjection\Configuration;

/**
 * @mixin Configuration
 */
class ConfigurationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\DependencyInjection\Configuration');
    }

    /**
     * @dataProvider get_configuration
     */
    public function it_should_process_configuration($config, $expected)
    {
        $processor = new Processor();

        expect($processor->processConfiguration(new Configuration(), [$config]))->shouldBe($expected);
    }

    public function get_configuration()
    {
        $extensions = [
            'attributes' => true,
            'table'      => true,
        ];

        $converter = [
            'converter'   => 'webuni_commonmark.converter',
            'environment' => 'webuni_commonmark.default_environment',
            'parser'      => 'webuni_commonmark.docparser',
            'renderer'    => 'webuni_commonmark.htmlrenderer',
            'config'      => [],
            'extensions'  => [],
        ];

        return [
            [
                [],
                [
                    'default_converter' => 'default',
                    'extensions'        => $extensions,
                    'converters'        => [
                        'default' => $converter,
                    ],
                ],
            ],
            [
                ['converters' => ['custom' => null]],
                [
                    'converters' => [
                        'default' => $converter,
                        'custom'  => $converter,
                    ],
                    'default_converter' => 'default',
                    'extensions'        => $extensions,
                ],
            ],
            [
                ['converters' => ['default' => ['config' => ['foo' => 'bar']]], 'extensions' => ['attributes' => false]],
                [
                    'converters' => [
                        'default' => ['config' => ['foo' => 'bar']] + $converter,
                    ],
                    'extensions'        => ['attributes' => false] + $extensions,
                    'default_converter' => 'default',
                ],
            ],
        ];
    }
}
