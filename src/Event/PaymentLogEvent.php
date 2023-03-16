<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Webmozart\Assert\Assert;

class PaymentLogEvent extends LogEvent
{
    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getPayment(): PaymentInterface
    {
        $return = $this->getSubject();
        Assert::isInstanceOf($return, PaymentInterface::class);

        return $return;
    }

    public function getOrder(): OrderInterface
    {
        /** @var OrderInterface $order */
        $order = $this->getPayment()->getOrder();

        return $order;
    }
}
