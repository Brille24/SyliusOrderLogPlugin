<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface PaymentLogEntryInterface
{
    public function getOrder(): OrderInterface;

    public function setOrder(OrderInterface $order): void;

    public function getPayment(): PaymentInterface;

    public function setPayment(PaymentInterface $payment): void;
}
