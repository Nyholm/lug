<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\ResourceBundle\Security;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
interface SecurityCheckerInterface
{
    /**
     * @param string $action
     * @param object $object
     *
     * @return bool
     */
    public function isGranted($action, $object);
}
