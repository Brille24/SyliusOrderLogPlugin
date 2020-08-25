<?php

declare(strict_types=1);

namespace spec\Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentInterface;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentLogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Event\PaymentLogEvent;
use Brille24\SyliusOrderLogPlugin\Listener\OrderListener;
use Brille24\SyliusOrderLogPlugin\Listener\PaymentListener;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PaymentListenerSpec extends ObjectBehavior
{
    private const DATA = [
        'state' => 'new',
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
        $this->shouldHaveType(PaymentListener::class);
    }

    public function it_is_an_event_subscriber(): void
    {
        $this->shouldBeAnInstanceOf(EventSubscriberInterface::class);
    }

    public function it_checks_for_differences(
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $paymentLogRepository,
        PaymentInterface $payment,
        OrderInterface $order,
        EntityManagerInterface $entityManager,
        PaymentLogEntryInterface $logEntry
    ): void {
        $this->setUp($logEntry, $payment, $order);
        $paymentLogRepository->findBy(['objectId' => 1], ['date' => 'ASC'])->shouldBeCalled()->willReturn([$logEntry]);
        $tokenStorage->getToken()->shouldNotBeCalled();

        $entityManager->persist(Argument::any())->shouldNotBeCalled();
        $entityManager->flush()->shouldNotBeCalled();

        $event = new PaymentLogEvent($payment->getWrappedObject(), LogEntryInterface::ACTION_UPDATE, self::DATA);
        $this->logPayment($event);
    }

    public function it_logs_an_order_not_checking_for_differences(
        TokenStorageInterface $tokenStorage,
        PaymentInterface $payment,
        OrderInterface $order,
        EntityManagerInterface $entityManager,
        PaymentLogEntryInterface $logEntry,
        TokenInterface $token,
        AdminUserInterface $adminUser
    ): void {
        $this->setUp($logEntry, $payment, $order);

        $tokenStorage->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($adminUser);

        $entityManager->persist(Argument::which('getData', self::DATA))->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $event = new PaymentLogEvent($payment->getWrappedObject(), LogEntryInterface::ACTION_UPDATE, self::DATA, false);
        $this->logPayment($event);
    }

    private function setUp(
        PaymentLogEntryInterface $logEntry,
        PaymentInterface $payment,
        OrderInterface $order
    ): void {
        $logEntry->getData()->willReturn(self::DATA);

        $payment->getId()->shouldBeCalled()->willReturn(1);
        $payment->getLoggableData()->willReturn(self::DATA);
        $payment->getOrder()->willReturn($order);

        $order->getId()->willReturn(1);
    }
}
