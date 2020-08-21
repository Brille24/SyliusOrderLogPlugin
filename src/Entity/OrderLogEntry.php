<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class OrderLogEntry extends LogEntry implements OrderLogEntryInterface
{
    /** @var int */
    protected $orderId;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }
}
