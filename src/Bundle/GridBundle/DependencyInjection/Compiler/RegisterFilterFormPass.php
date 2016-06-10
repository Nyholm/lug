<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\GridBundle\DependencyInjection\Compiler;

use Lug\Bundle\RegistryBundle\DependencyInjection\Compiler\RegisterRegistryPass;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class RegisterFilterFormPass extends RegisterRegistryPass
{
    public function __construct()
    {
        parent::__construct('lug.grid.registry.filter.form', 'lug.grid.filter.form', 'filter');
    }
}
