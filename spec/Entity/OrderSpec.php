<?php

declare(strict_types=1);

namespace spec\Brille24\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\OrderCheckoutStates;
use Sylius\Component\Core\OrderPaymentStates;
use Sylius\Component\Core\OrderShippingStates;

class OrderSpec extends ObjectBehavior
{
    public function it_return_loggable_data(): void
    {
        $this->setState(OrderInterface::STATE_NEW);
        $this->setCheckoutState(OrderCheckoutStates::STATE_COMPLETED);
        $this->setPaymentState(OrderPaymentStates::STATE_AWAITING_PAYMENT);
        $this->setShippingState(OrderShippingStates::STATE_READY);

        $this->getLoggableData()->shouldReturn([
            'state' => OrderInterface::STATE_NEW,
            'checkoutState' => OrderCheckoutStates::STATE_COMPLETED,
            'paymentState' => OrderPaymentStates::STATE_AWAITING_PAYMENT,
            'shippingState' => OrderShippingStates::STATE_READY,
        ]);
    }
}
