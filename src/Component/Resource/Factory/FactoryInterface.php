<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Resource\Factory;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
interface FactoryInterface
{
    /**
     * @param mixed[] $options
     *
     * @return object
     */
    public function create(array $options = []);
}
