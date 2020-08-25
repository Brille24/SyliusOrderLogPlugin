<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentInterface;

class ShipmentLogEvent extends LogEvent
{
    public function getShipment(): ShipmentInterface
    {
        return $this->getSubject();
    }

    public function getOrder(): OrderInterface
    {
        /** @var OrderInterface $order */
        $order = $this->getShipment()->getOrder();

        return $order;
    }
}
