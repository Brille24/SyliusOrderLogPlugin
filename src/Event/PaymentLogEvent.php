<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentInterface;

class PaymentLogEvent extends LogEvent
{
    public function getPayment(): PaymentInterface
    {
        return $this->getSubject();
    }

    public function getOrder(): OrderInterface
    {
        return $this->getPayment()->getOrder();
    }
}
