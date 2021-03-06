<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\ResourceBundle\Tests\DependencyInjection\Compiler;

use Lug\Bundle\ResourceBundle\DependencyInjection\Compiler\ReplaceBase64FileExtensionPass;
use Lug\Bundle\ResourceBundle\Form\Extension\Base64FileExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ReplaceBase64FileExtensionPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReplaceBase64FileExtensionPass
     */
    private $compiler;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->compiler = new ReplaceBase64FileExtensionPass();
    }

    public function testProcessWithService()
    {
        $container = $this->createContainerBuilderMock();
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with($this->identicalTo($service = 'ivory.base64_file.form.extension'))
            ->will($this->returnValue(true));

        $container
            ->expects($this->once())
            ->method('getDefinition')
            ->with($this->identicalTo($service))
            ->will($this->returnValue($definition = $this->createDefinitionMock()));

        $definition
            ->expects($this->once())
            ->method('setClass')
            ->with($this->identicalTo(Base64FileExtension::class))
            ->will($this->returnSelf());

        $definition
            ->expects($this->once())
            ->method('replaceArgument')
            ->with(
                $this->identicalTo(0),
                $this->callback(function ($reference) {
                    return $reference instanceof Reference
                        && (string) $reference === 'lug.resource.routing.parameter_resolver';
                })
            );

        $this->compiler->process($container);
    }

    public function testProcessWithoutService()
    {
        $container = $this->createContainerBuilderMock();
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with($this->identicalTo($service = 'ivory.base64_file.form.extension'))
            ->will($this->returnValue(false));

        $container
            ->expects($this->never())
            ->method('getDefinition');

        $this->compiler->process($container);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder
     */
    private function createContainerBuilderMock()
    {
        return $this->createMock(ContainerBuilder::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Definition
     */
    private function createDefinitionMock()
    {
        return $this->createMock(Definition::class);
    }
}
