<?php

/*
 * This is part of the webuni/commonmark-bundle package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\Bundle\CommonMarkBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webuni\Bundle\CommonMarkBundle\DependencyInjection\Compiler\CommonMarkExtensionPass;
use Webuni\Bundle\CommonMarkBundle\DependencyInjection\WebuniCommonMarkExtension;

class WebuniCommonMarkBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CommonMarkExtensionPass());
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new WebuniCommonMarkExtension();
        }

        return $this->extension;
    }
}
