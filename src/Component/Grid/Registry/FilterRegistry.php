<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Grid\Registry;

use Lug\Component\Grid\Filter\Type\TypeInterface;
use Lug\Component\Registry\Model\ServiceRegistry;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class FilterRegistry extends ServiceRegistry
{
    /**
     * @param TypeInterface[] $types
     */
    public function __construct(array $types = [])
    {
        parent::__construct(TypeInterface::class, $types);
    }
}
