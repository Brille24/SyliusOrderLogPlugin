<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class PaymentLogEntry extends LogEntry implements PaymentLogEntryInterface
{
    /** @var OrderInterface */
    protected $order;

    /** @var PaymentInterface */
    protected $payment;

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getPayment(): PaymentInterface
    {
        return $this->payment;
    }

    public function setPayment(PaymentInterface $payment): void
    {
        $this->payment = $payment;
    }
}
