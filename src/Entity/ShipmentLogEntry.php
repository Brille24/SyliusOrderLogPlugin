<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class ShipmentLogEntry extends LogEntry implements ShipmentLogEntryInterface
{
    /** @var int */
    protected $objectId;

    /** @var int */
    protected $orderId;

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }
}
