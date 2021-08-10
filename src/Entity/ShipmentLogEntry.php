<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class ShipmentLogEntry extends LogEntry implements ShipmentLogEntryInterface
{
    /** @var int */
    protected $orderId;

    public function __construct()
    {
        parent::__construct();
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
