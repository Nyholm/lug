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

use Lug\Component\Registry\Model\ServiceRegistry;
use Lug\Component\Resource\Domain\DomainManagerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DomainManagerRegistry extends ServiceRegistry
{
    /**
     * @param DomainManagerInterface[] $domainManagers
     */
    public function __construct(array $domainManagers = [])
    {
        parent::__construct(DomainManagerInterface::class, $domainManagers);
    }
}
