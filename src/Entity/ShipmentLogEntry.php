<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class ShipmentLogEntry extends LogEntry implements ShipmentLogEntryInterface
{
    /** @var OrderInterface */
    protected $order;

    /** @var ShipmentInterface */
    protected $shipment;

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getShipment(): ShipmentInterface
    {
        return $this->shipment;
    }

    public function setShipment(ShipmentInterface $shipment): void
    {
        $this->shipment = $shipment;
    }
}
