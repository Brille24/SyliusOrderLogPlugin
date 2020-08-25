<?php

declare(strict_types=1);

namespace spec\Brille24\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\ShipmentInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShippingMethodInterface;

class ShipmentSpec extends ObjectBehavior
{
    public function it_returns_loggable_data(ShippingMethodInterface $method): void
    {
        $method->getCode()->willReturn('method_code');

        $this->setState(ShipmentInterface::STATE_CANCELLED);
        $this->setMethod($method);
        $this->setTracking('abc');

        $this->getLoggableData()->shouldReturn([
            'state' => ShipmentInterface::STATE_CANCELLED,
            'method' => 'method_code',
            'tracking' => 'abc',
        ]);
    }
}
