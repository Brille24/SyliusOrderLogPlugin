<?php

declare(strict_types=1);

namespace spec\Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderLogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Event\OrderLogEvent;
use Brille24\SyliusOrderLogPlugin\Listener\OrderListener;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class OrderListenerSpec extends ObjectBehavior
{
    private const DATA = [
        'state' => 'new',
        'paymentState' => 'paid',
        'checkoutState' => 'finished',
        'shippingState' => 'ready',
    ];

    public function let(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        RepositoryInterface $orderLogRepository
    ): void {
        $this->beConstructedWith($tokenStorage, $entityManager, $orderLogRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(OrderListener::class);
    }

    public function it_is_an_event_subscriber(): void
    {
        $this->shouldBeAnInstanceOf(EventSubscriberInterface::class);
    }

    public function it_logs_an_order_checking_for_differences(
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $orderLogRepository,
        OrderInterface $order,
        EntityManagerInterface $entityManager,
        OrderLogEntryInterface $logEntry,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $this->setUp($tokenStorage, $logEntry, $token, $adminUser, $order);
        $orderLogRepository->findBy(['objectId' => 1], ['date' => 'ASC'])->shouldBeCalled()->willReturn([$logEntry]);

        $expectedData = ['paymentState' => 'paid'];

        $entityManager->persist(Argument::which('getData', $expectedData))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $event = new OrderLogEvent($order->getWrappedObject(), LogEntryInterface::ACTION_UPDATE, self::DATA);
        $this->logOrder($event);
    }

    public function it_logs_an_order_not_checking_for_differences(
        TokenStorageInterface $tokenStorage,
        OrderInterface $order,
        EntityManagerInterface $entityManager,
        OrderLogEntryInterface $logEntry,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $this->setUp($tokenStorage, $logEntry, $token, $adminUser, $order);

        $entityManager->persist(Argument::which('getData', self::DATA))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $event = new OrderLogEvent($order->getWrappedObject(), LogEntryInterface::ACTION_UPDATE, self::DATA, false);
        $this->logOrder($event);
    }

    private function setUp(
        TokenStorageInterface $tokenStorage,
        OrderLogEntryInterface $logEntry,
        TokenInterface $token,
        AdminUserInterface $adminUser,
        OrderInterface $order
    ): void {
        $logEntry->getData()->willReturn([
            'state' => 'new',
            'paymentState' => 'awaiting_payment',
            'checkoutState' => 'finished',
            'shippingState' => 'ready',
        ]);

        $order->getId()->shouldBeCalled()->willReturn(1);
        $order->getLoggableData()->willReturn(self::DATA);

        $tokenStorage->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($adminUser);
    }
}
