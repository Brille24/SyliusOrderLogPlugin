<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface PaymentLogEntryInterface
{
    public function getOrderId(): int;

    public function setOrderId(int $order): void;

    public function getPaymentId(): int;

    public function setPaymentId(int $payment): void;
}
