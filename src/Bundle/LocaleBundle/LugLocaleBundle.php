<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\LocaleBundle;

use Lug\Bundle\LocaleBundle\DependencyInjection\Compiler\RegisterValidationMetadataPass;
use Lug\Bundle\LocaleBundle\Resource\LocaleResource;
use Lug\Bundle\ResourceBundle\AbstractResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class LugLocaleBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterValidationMetadataPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function createResources($driver)
    {
        return [new LocaleResource($driver)];
    }
}
