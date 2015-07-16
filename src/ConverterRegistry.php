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

class ConverterRegistry
{
    private $converters;

    /**
     * Constructor.
     *
     * @param Converter[] $converters
     */
    public function __construct(array $converters = [])
    {
        $this->converters = $converters;
    }

    public function has($name)
    {
        return isset($this->converters[$name]);
    }

    public function get($name)
    {
        return $this->converters[$name];
    }
}
