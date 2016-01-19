<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\GridBundle\DataSource;

use Lug\Component\Grid\DataSource\DataSourceInterface;
use Pagerfanta\Pagerfanta;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class PagerfantaDataSource extends Pagerfanta implements DataSourceInterface
{
}
