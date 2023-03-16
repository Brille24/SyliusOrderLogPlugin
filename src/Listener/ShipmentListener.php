<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLogEntry;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLoggableInterface;
use Brille24\SyliusOrderLogPlugin\Event\ShipmentLogEvent;
use Brille24\SyliusOrderLogPlugin\Repository\LogEntryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ShipmentInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

class ShipmentListener implements EventSubscriberInterface
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

    public function logShipment(ShipmentLogEvent $event): void
    {
        $data = $this->getDataToLog($event, $event->getShipment()->getId());

        // Don't log empty data
        if (0 === count($data)) {
            return;
        }

        $logEntry = new ShipmentLogEntry();
        $logEntry->setDate(new \DateTime('now'));
        $logEntry->setAction($event->getAction());
        /** @psalm-suppress MixedArgument */
        $logEntry->setOrderId($event->getOrder()->getId());
        $logEntry->setObjectId($event->getShipment()->getId());
        $logEntry->setData($data);

        $this->handleUser($logEntry);

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }

    public function createShipment(ResourceControllerEvent $event): void
    {
        /** @var ShipmentInterface $shipment */
        $shipment = $event->getSubject();

        $this->logShipment($this->getLogEvent($shipment, LogEntryInterface::ACTION_CREATE));
    }

    public function updateShipment(ResourceControllerEvent $event): void
    {
        /** @var ShipmentInterface $shipment */
        $shipment = $event->getSubject();

        $this->logShipment($this->getLogEvent($shipment, LogEntryInterface::ACTION_UPDATE));
    }

    public function deleteShipment(ResourceControllerEvent $event): void
    {
        /** @var ShipmentInterface $shipment */
        $shipment = $event->getSubject();

        $this->logShipment($this->getLogEvent($shipment, LogEntryInterface::ACTION_DELETE));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ShipmentLogEvent::class => 'logShipment',
            'sylius.shipment.post_create' => 'createShipment',
            'sylius.shipment.post_update' => 'updateShipment',
            'sylius.shipment.post_delete' => 'deleteShipment',
            'sylius.shipment.post_ship' => 'updateShipment',
        ];
    }

    private function getLogEvent(ShipmentInterface $shipment, string $action): ShipmentLogEvent
    {
        Assert::isInstanceOf($shipment, ShipmentLoggableInterface::class);

        return new ShipmentLogEvent($shipment, $action, $shipment->getLoggableData());
    }
}
