<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLogEntry;
use Brille24\SyliusOrderLogPlugin\Event\ShipmentLogEvent;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShipmentListener implements EventSubscriberInterface
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var RepositoryInterface */
    protected $shipmentLogRepository;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        RepositoryInterface $shipmentLogRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        $this->shipmentLogRepository = $shipmentLogRepository;
    }

    public function logShipment(ShipmentLogEvent $event): void
    {
        $data = $event->getData();
        if ($event->onlyDifferences()) {
            // Rebuild last logged data
            $loggedData = [];
            /** @var LogEntryInterface $log */
            foreach ($this->shipmentLogRepository->findBy(
                ['objectId' => $event->getShipment()->getId()],
                ['date' => 'ASC']
            ) as $log) {
                $loggedData = array_merge($loggedData, $log->getData());
            }

            // Get data difference
            $data = array_diff_assoc($event->getData(), $loggedData);
        }

        // Don't log empty data
        if (0 === count($data)) {
            return;
        }

        $logEntry = new ShipmentLogEntry();

        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof AdminUserInterface) {
            $logEntry->setUser($user);
        }
        $logEntry->setDate(new \DateTime('now'));
        $logEntry->setAction($event->getAction());
        $logEntry->setOrderId($event->getOrder()->getId());
        $logEntry->setObjectId($event->getShipment()->getId());
        $logEntry->setData($data);

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

    public static function getSubscribedEvents()
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
        return new ShipmentLogEvent($shipment, $action, $shipment->getLoggableData());
    }
}
