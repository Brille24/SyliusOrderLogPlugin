<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class ShipmentLogEntry extends LogEntry implements ShipmentLogEntryInterface
{
    /** @var int */
    protected $orderId;

    /** @var int */
    protected $shipmentId;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getShipmentId(): int
    {
        return $this->shipmentId;
    }

    public function setShipmentId(int $shipmentId): void
    {
        $this->shipmentId = $shipmentId;
    }
}
