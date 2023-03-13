<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;

class PaymentLogEvent extends LogEvent
{
    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getPayment(): PaymentInterface
    {
        return $this->getSubject();
    }

    public function getOrder(): OrderInterface
    {
        /** @var OrderInterface $order */
        $order = $this->getPayment()->getOrder();

        return $order;
    }
}
