<?php

/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\ResourceBundle\Tests\Rest;

use Lug\Bundle\ResourceBundle\Rest\AbstractEvent;
use Lug\Component\Resource\Model\ResourceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|AbstractEvent
     */
    private $event;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ResourceInterface
     */
    private $resource;

    /**
     * @var string
     */
    private $action;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->resource = $this->createResourceMock();
        $this->action = 'create';

        $this->event = $this->getMockBuilder(AbstractEvent::class)
            ->setConstructorArgs([$this->resource, $this->action])
            ->getMockForAbstractClass();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf(Event::class, $this->event);
    }

    public function testInitialState()
    {
        $this->assertSame($this->resource, $this->event->getResource());
        $this->assertSame($this->action, $this->event->getAction());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResourceInterface
     */
    private function createResourceMock()
    {
        return $this->createMock(ResourceInterface::class);
    }
}
