<?php

/*
 * This is part of the webuni/commonmark-bundle package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Webuni\Bundle\CommonMarkBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebuniCommonMarkBundleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webuni\Bundle\CommonMarkBundle\WebuniCommonMarkBundle');
    }

    public function it_should_implements_symfony_bundle()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\HttpKernel\Bundle\Bundle');
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function it_should_register_dependency_injection_compiler_for_commonmark_extensions($container)
    {
        $container->addCompilerPass(Argument::type('Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass'))->shouldBeCalled();

        $this->build($container);
    }
}
