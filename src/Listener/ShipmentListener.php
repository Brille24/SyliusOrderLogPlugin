<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\OrderLogEntry;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentLogEntry;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLogEntry;
use Brille24\SyliusOrderLogPlugin\Event\OrderLogEvent;
use Brille24\SyliusOrderLogPlugin\Event\PaymentLogEvent;
use Brille24\SyliusOrderLogPlugin\Event\ShipmentLogEvent;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShipmentListener implements EventSubscriberInterface
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    public function logShipment(ShipmentLogEvent $event): void
    {
        $logEntry = new ShipmentLogEntry();

        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof AdminUserInterface) {
            $logEntry->setUser($user);
        }
        $logEntry->setDate(new \DateTime('now'));
        $logEntry->setAction($event->getAction());
        $logEntry->setOrder($event->getOrder());
        $logEntry->setShipment($event->getShipment());
        $logEntry->setData($event->getData());

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            ShipmentLogEvent::class => 'logShipment',
        ];
    }
}
