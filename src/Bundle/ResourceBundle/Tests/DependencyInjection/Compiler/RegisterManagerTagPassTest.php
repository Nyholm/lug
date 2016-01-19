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

use Lug\Bundle\ResourceBundle\DependencyInjection\Compiler\RegisterManagerTagPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class RegisterManagerTagPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RegisterManagerTagPass
     */
    private $compiler;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->compiler = new RegisterManagerTagPass();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(CompilerPassInterface::class, $this->compiler);
    }

    public function testProcess()
    {
        $container = $this->createContainerBuilderMock();
        $container
            ->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo('lug.resource'))
            ->will($this->returnValue([$resource = 'my.resource' => []]));

        $container
            ->expects($this->exactly(2))
            ->method('getDefinition')
            ->will($this->returnValueMap([
                [$resource, $resourceDefinition = $this->createDefinitionMock()],
                [$alias = 'manager_alias', $aliasDefinition = $this->createDefinitionMock()],
            ]));

        $resourceDefinition
            ->expects($this->once())
            ->method('getArgument')
            ->with($this->identicalTo(0))
            ->will($this->returnValue($resourceName = 'resource_name'));

        $container
            ->expects($this->once())
            ->method('getAlias')
            ->with($this->identicalTo('lug.manager.'.$resourceName))
            ->will($this->returnValue($alias));

        $aliasDefinition
            ->expects($this->once())
            ->method('hasTag')
            ->with($this->identicalTo($tag = 'lug.manager'))
            ->will($this->returnValue(false));

        $aliasDefinition
            ->expects($this->once())
            ->method('addTag')
            ->with(
                $this->identicalTo($tag),
                $this->identicalTo(['resource' => $resourceName])
            );

        $this->compiler->process($container);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder
     */
    private function createContainerBuilderMock()
    {
        return $this->getMock(ContainerBuilder::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Definition
     */
    private function createDefinitionMock()
    {
        return $this->getMock(Definition::class);
    }
}
