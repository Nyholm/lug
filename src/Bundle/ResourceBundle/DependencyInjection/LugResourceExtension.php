<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\ResourceBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class LugResourceExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $resources = [
            'configurator',
            'event_listener',
            'event_subscriber',
            'form',
            'hateaos',
            'registry',
            'repository',
            'rest',
            'routing',
            'security',
        ];

        foreach ($resources as $resource) {
            $loader->load($resource.'.xml');
        }
    }
}
