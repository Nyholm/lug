<?php
/*
 * This file is part of the Lug package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lug\Bundle\ResourceBundle\EventListener;

use Lug\Component\Resource\Domain\DomainEvent;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MessageListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @param TranslatorInterface       $translator
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function __construct(TranslatorInterface $translator, PropertyAccessorInterface $propertyAccessor)
    {
        $this->translator = $translator;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @param DomainEvent $event
     */
    public function addMessage(DomainEvent $event)
    {
        $messageType = $event->getMessageType();
        $message = $event->getMessage();

        if (empty($messageType)) {
            $messageType = $event->isStopped() ? 'error' : 'success';
        }

        if (empty($message)) {
            $object = $event->getObject();
            $resource = $event->getResource();
            $name = $resource->getName();
            $labelPropertyPath = $resource->getLabelPropertyPath();
            $property = $labelPropertyPath !== null
                ? $this->propertyAccessor->getValue($object, $labelPropertyPath)
                : (string) $object;

            $message = $this->translator->trans(
                'lug.'.$name.'.'.$event->getAction().'.'.$messageType,
                ['%'.$name.'%' => $property],
                'flashes'
            );
        }

        $event->setMessageType($messageType);
        $event->setMessage($message);
    }
}
