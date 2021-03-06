<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderLogEntry;
use Brille24\SyliusOrderLogPlugin\Event\OrderLogEvent;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderListener implements EventSubscriberInterface
{
    use LogListenerTrait {
        __construct as private init;
    }

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $logEntryRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;

        $this->init($tokenStorage, $logEntryRepository);
    }

    public function logOrder(OrderLogEvent $event): void
    {
        $data = $this->getDataToLog($event, $event->getOrder()->getId());

        // Don't log empty data
        if (0 === count($data)) {
            return;
        }

        $logEntry = new OrderLogEntry();
        $logEntry->setDate(new \DateTime('now'));
        $logEntry->setAction($event->getAction());
        $logEntry->setObjectId($event->getOrder()->getId());
        $logEntry->setData($data);

        $this->handleUser($logEntry);

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }

    public function createOrder(ResourceControllerEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_CREATE));
    }

    public function updateOrder(ResourceControllerEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_UPDATE));
    }

    public function deleteOrder(ResourceControllerEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_DELETE));
    }

    public function updatePayment(ResourceControllerEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject()->getOrder();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_UPDATE));
    }

    public function updateShipment(ResourceControllerEvent $event): void
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject()->getOrder();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_UPDATE));
    }

    public static function getSubscribedEvents()
    {
        return [
            OrderLogEvent::class => 'logOrder',
            'sylius.order.post_complete' => 'createOrder',
            'sylius.order.post_create' => 'createOrder',
            'sylius.order.post_update' => 'updateOrder',
            'sylius.order.post_delete' => 'deleteOrder',
            'sylius.payment.post_complete' => 'updatePayment',
            'sylius.payment.post_update' => 'updatePayment',
            'sylius.shipment.post_ship' => 'updateShipment',
        ];
    }

    private function getLogEvent(OrderInterface $order, string $action): OrderLogEvent
    {
        return new OrderLogEvent($order, $action, $order->getLoggableData());
    }
}
