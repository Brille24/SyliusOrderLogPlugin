<?php

declare(strict_types=1);

namespace spec\Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Event\ShipmentLogEvent;
use Brille24\SyliusOrderLogPlugin\Listener\ShipmentListener;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ShipmentListenerSpec extends ObjectBehavior
{
    private const DATA = [
        'state' => 'ready',
    ];

    public function let(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        RepositoryInterface $paymentLogRepository
    ): void {
        $this->beConstructedWith($tokenStorage, $entityManager, $paymentLogRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ShipmentListener::class);
    }

    public function it_is_an_event_subscriber(): void
    {
        $this->shouldBeAnInstanceOf(EventSubscriberInterface::class);
    }

    public function it_checks_for_differences(
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $paymentLogRepository,
        ShipmentInterface $shipment,
        OrderInterface $order,
        EntityManagerInterface $entityManager,
        ShipmentLogEntryInterface $logEntry
    ): void {
        $this->setUp($logEntry, $shipment, $order);
        $paymentLogRepository->findBy(['objectId' => 1], ['date' => 'ASC'])->shouldBeCalled()->willReturn([$logEntry]);
        $tokenStorage->getToken()->shouldNotBeCalled();

        $entityManager->persist(Argument::any())->shouldNotBeCalled();
        $entityManager->flush()->shouldNotBeCalled();

        $event = new ShipmentLogEvent($shipment->getWrappedObject(), LogEntryInterface::ACTION_UPDATE, self::DATA);
        $this->logShipment($event);
    }

    public function it_logs_an_order_not_checking_for_differences(
        TokenStorageInterface $tokenStorage,
        ShipmentInterface $shipment,
        OrderInterface $order,
        EntityManagerInterface $entityManager,
        ShipmentLogEntryInterface $logEntry,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $this->setUp($logEntry, $shipment, $order);

        $tokenStorage->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($adminUser);

        $entityManager->persist(Argument::which('getData', self::DATA))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $event = new ShipmentLogEvent(
            $shipment->getWrappedObject(),
            LogEntryInterface::ACTION_UPDATE,
            self::DATA,
            false
        );
        $this->logShipment($event);
    }

    private function setUp(
        ShipmentLogEntryInterface $logEntry,
        ShipmentInterface $shipment,
        OrderInterface $order
    ): void {
        $logEntry->getData()->willReturn(self::DATA);

        $shipment->getId()->shouldBeCalled()->willReturn(1);
        $shipment->getLoggableData()->willReturn(self::DATA);
        $shipment->getOrder()->willReturn($order);

        $order->getId()->willReturn(1);
    }
}
