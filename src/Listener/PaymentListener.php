<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentInterface;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentLogEntry;
use Brille24\SyliusOrderLogPlugin\Event\PaymentLogEvent;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PaymentListener implements EventSubscriberInterface
{
    use LogListenerTrait;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var RepositoryInterface */
    protected $logEntryRepository;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        RepositoryInterface $logEntryRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        $this->logEntryRepository = $logEntryRepository;
    }

    public function logPayment(PaymentLogEvent $event): void
    {
        $data = $this->getDataToLog($event, $event->getPayment()->getId());

        // Don't log empty data
        if (0 === count($data)) {
            return;
        }

        $logEntry = new PaymentLogEntry();
        $logEntry->setDate(new \DateTime('now'));
        $logEntry->setAction($event->getAction());
        $logEntry->setOrderId($event->getOrder()->getId());
        $logEntry->setObjectId($event->getPayment()->getId());
        $logEntry->setData($data);

        $this->handleUser($logEntry);

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }

    public function createPayment(ResourceControllerEvent $event): void
    {
        /** @var PaymentInterface $payment */
        $payment = $event->getSubject();

        $this->logPayment($this->getLogEvent($payment, LogEntryInterface::ACTION_CREATE));
    }

    public function updatePayment(ResourceControllerEvent $event): void
    {
        /** @var PaymentInterface $payment */
        $payment = $event->getSubject();

        $this->logPayment($this->getLogEvent($payment, LogEntryInterface::ACTION_UPDATE));
    }

    public function deletePayment(ResourceControllerEvent $event): void
    {
        /** @var PaymentInterface $payment */
        $payment = $event->getSubject();

        $this->logPayment($this->getLogEvent($payment, LogEntryInterface::ACTION_DELETE));
    }

    public static function getSubscribedEvents()
    {
        return [
            PaymentLogEvent::class => 'logPayment',
            'sylius.payment.post_create' => 'createPayment',
            'sylius.payment.post_update' => 'updatePayment',
            'sylius.payment.post_delete' => 'deletePayment',
            'sylius.payment.post_complete' => 'updatePayment',
        ];
    }

    private function getLogEvent(PaymentInterface $payment, string $action): PaymentLogEvent
    {
        return new PaymentLogEvent($payment, $action, $payment->getLoggableData());
    }
}
