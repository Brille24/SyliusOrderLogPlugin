<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Webmozart\Assert\Assert;

class ShipmentLogEvent extends LogEvent
{
    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getShipment(): ShipmentInterface
    {
        $return = $this->getSubject();
        Assert::isInstanceOf($return, ShipmentInterface::class);

        return $return;
    }

    public function getOrder(): OrderInterface
    {
        /** @var OrderInterface $order */
        $order = $this->getShipment()->getOrder();

        return $order;
    }
}
