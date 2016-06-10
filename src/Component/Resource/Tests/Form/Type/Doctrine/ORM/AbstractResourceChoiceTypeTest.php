<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Component\Resource\Tests\Form\Type\Doctrine\ORM;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Lug\Component\Resource\Form\Type\Doctrine\ORM\AbstractResourceChoiceType;
use Lug\Component\Resource\Form\Type\Doctrine\ORM\ResourceChoiceType;
use Lug\Component\Resource\Model\ResourceInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class AbstractResourceChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @var AbstractResourceChoiceType
     */
    private $resourceChoiceType;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ResourceInterface
     */
    private $resource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ManagerRegistry
     */
    private $managerRegistry;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->resource = $this->createResourceMock();
        $this->managerRegistry = $this->createManagerRegistryMock();

        $this->resource
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('model'));

        $this->resourceChoiceType = $this->getMockBuilder(AbstractResourceChoiceType::class)
            ->setConstructorArgs([$this->resource])
            ->getMockForAbstractClass();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addType(new EntityType($this->managerRegistry))
            ->addType(new ResourceChoiceType())
            ->addType($this->resourceChoiceType)
            ->getFormFactory();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(AbstractType::class, $this->resourceChoiceType);
        $this->assertSame(ResourceChoiceType::class, $this->resourceChoiceType->getParent());
    }

    public function testSubmit()
    {
        $choice = new \stdClass();
        $choice->{$identifierPath = 'id'} = $id = 1;
        $choice->{$labelPath = 'label'} = $label = 'label';

        $this->resource
            ->expects($this->once())
            ->method('getModel')
            ->will($this->returnValue($model = get_class($choice)));

        $this->resource
            ->expects($this->once())
            ->method('getIdPropertyPath')
            ->will($this->returnValue($identifierPath));

        $this->resource
            ->expects($this->once())
            ->method('getLabelPropertyPath')
            ->will($this->returnValue($labelPath));

        $this->managerRegistry
            ->expects($this->once())
            ->method('getManagerForClass')
            ->with($this->identicalTo($model))
            ->will($this->returnValue($entityManager = $this->createEntityManagerMock()));

        $entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->identicalTo($model))
            ->will($this->returnValue($repository = $this->createRepositoryMock()));

        $entityManager
            ->expects($this->exactly(2))
            ->method('getClassMetadata')
            ->with($this->identicalTo($model))
            ->will($this->returnValue($classMetadata = $this->createClassMetadataMock()));

        $classMetadata
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($model));

        $classMetadata
            ->expects($this->once())
            ->method('getIdentifierFieldNames')
            ->will($this->returnValue([$identifier = $identifierPath]));

        $classMetadata
            ->expects($this->once())
            ->method('getTypeOfField')
            ->with($this->identicalTo($identifier))
            ->will($this->returnValue('integer'));

        $repository
            ->expects($this->once())
            ->method('createQueryBuilder')
            ->will($this->returnValue($queryBuilder = $this->createQueryBuilderMock($entityManager)));

        $queryBuilder
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query = $this->createQueryMock()));

        $query
            ->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($choices = [$choice]));

        $form = $this->factory
            ->create(get_class($this->resourceChoiceType))
            ->submit($id);

        $this->assertSame($this->resource, $form->getConfig()->getOption('resource'));
        $this->assertSame($choice, $form->getData());

        $form->createView();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResourceInterface
     */
    private function createResourceMock()
    {
        return $this->createMock(ResourceInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ManagerRegistry
     */
    private function createManagerRegistryMock()
    {
        return $this->createMock(ManagerRegistry::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManagerInterface
     */
    private function createEntityManagerMock()
    {
        return $this->createMock(EntityManagerInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ClassMetadata
     */
    private function createClassMetadataMock()
    {
        return $this->createMock(ClassMetadata::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityRepository
     */
    private function createRepositoryMock()
    {
        return $this->createMock(EntityRepository::class);
    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|QueryBuilder
     */
    private function createQueryBuilderMock(EntityManagerInterface $entityManager)
    {
        return $this->getMockBuilder(QueryBuilder::class)
            ->setConstructorArgs([$entityManager])
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Query
     */
    private function createQueryMock()
    {
        return $this->getMockBuilder(\stdClass::class)
            ->setMethods(['execute', 'setParameter', 'getResult'])
            ->getMock();
    }
}
