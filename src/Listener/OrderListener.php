<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderLogEntry;
use Brille24\SyliusOrderLogPlugin\Entity\OrderLoggableInterface;
use Brille24\SyliusOrderLogPlugin\Event\OrderLogEvent;
use Brille24\SyliusOrderLogPlugin\Repository\LogEntryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

class OrderListener implements EventSubscriberInterface
{
    use LogListenerTrait {
        __construct as private init;
    }

    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private LogEntryRepositoryInterface $logEntryRepository,
        private EntityManagerInterface $entityManager
    ) {
        $this->init($this->tokenStorage, $this->logEntryRepository);
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
        /** @var PaymentInterface $payment */
        $payment = $event->getSubject();
        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_UPDATE));
    }

    public function updateShipment(ResourceControllerEvent $event): void
    {
        /** @var ShipmentInterface  $shipment */
        $shipment = $event->getSubject();
        /** @var OrderInterface $order */
        $order = $shipment->getOrder();

        $this->logOrder($this->getLogEvent($order, LogEntryInterface::ACTION_UPDATE));
    }

    public static function getSubscribedEvents(): array
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
        Assert::isInstanceOf($order, OrderLoggableInterface::class);

        return new OrderLogEvent($order, $action, $order->getLoggableData());
    }
}
