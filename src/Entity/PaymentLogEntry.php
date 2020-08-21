<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class PaymentLogEntry extends LogEntry implements PaymentLogEntryInterface
{
    /** @var int */
    protected $orderId;

    /** @var int */
    protected $paymentId;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function setPaymentId(int $paymentId): void
    {
        $this->paymentId = $paymentId;
    }
}
