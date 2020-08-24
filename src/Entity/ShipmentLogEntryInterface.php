<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface ShipmentLogEntryInterface extends LogEntryInterface
{
    public function getOrderId(): int;

    public function setOrderId(int $orderId): void;
}
