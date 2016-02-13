<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Resource\Registry;

use Lug\Component\Registry\Model\Registry;
use Lug\Component\Resource\Factory\FactoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class FactoryRegistry extends Registry
{
    /**
     * @param FactoryInterface[] $factories
     */
    public function __construct(array $factories = [])
    {
        parent::__construct(FactoryInterface::class, $factories);
    }
}
