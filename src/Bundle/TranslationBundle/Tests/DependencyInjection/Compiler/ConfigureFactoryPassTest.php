<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\TranslationBundle\Tests\DependencyInjection\Compiler;

use Lug\Bundle\TranslationBundle\DependencyInjection\Compiler\ConfigureFactoryPass;
use Lug\Component\Resource\Factory\Factory;
use Lug\Component\Translation\Factory\TranslatableFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ConfigureFactoryPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigureFactoryPass
     */
    private $compiler;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->compiler = new ConfigureFactoryPass();
    }

    public function testProcessWithTranslatable()
    {
        $container = $this->createContainerBuilderMock();
        $container
            ->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo('lug.factory'))
            ->will($this->returnValue([
                $factoryService = 'lug.factory.resource_name' => [['resource' => $resourceName = 'resource_name']],
            ]));

        $container
            ->expects($this->exactly(3))
            ->method('getDefinition')
            ->will($this->returnValueMap([
                [$factoryService, $factory = $this->createDefinitionMock()],
                [$resourceService = 'lug.resource.resource_name', $resource = $this->createDefinitionMock()],
                [$translationService = 'lug.resource.translation_name', $translation = $this->createDefinitionMock()],
            ]));

        $factory
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue(TranslatableFactory::class));

        $resource
            ->expects($this->once())
            ->method('getMethodCalls')
            ->will($this->returnValue([['addRelation', ['translation', $translationService]]]));

        $translation
            ->expects($this->once())
            ->method('getArgument')
            ->with($this->identicalTo(0))
            ->will($this->returnValue($translationName = 'translation_name'));

        $factory
            ->expects($this->at(1))
            ->method('addArgument')
            ->with($this->callback(function ($argument) {
                return $argument instanceof Reference
                    && (string) $argument === 'lug.translation.context.locale';
            }))
            ->will($this->returnSelf());

        $factory
            ->expects($this->at(2))
            ->method('addArgument')
            ->with($this->callback(function ($argument) use ($translationName) {
                return $argument instanceof Reference
                    && (string) $argument === 'lug.factory.'.$translationName;
            }))
            ->will($this->returnSelf());

        $this->compiler->process($container);
    }

    public function testProcessWithoutTranslatable()
    {
        $container = $this->createContainerBuilderMock();
        $container
            ->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo('lug.factory'))
            ->will($this->returnValue([$service = 'service' => []]));

        $container
            ->expects($this->once())
            ->method('getDefinition')
            ->with($this->identicalTo($service))
            ->will($this->returnValue($factory = $this->createDefinitionMock()));

        $factory
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue(Factory::class));

        $factory
            ->expects($this->never())
            ->method('addArgument');

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
