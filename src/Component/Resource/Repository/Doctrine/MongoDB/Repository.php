<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Resource\Repository\Doctrine\MongoDB;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Lug\Component\Resource\Repository\RepositoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Repository extends DocumentRepository implements RepositoryInterface
{
    use RepositoryTrait;
}
