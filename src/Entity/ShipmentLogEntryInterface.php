<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface ShipmentLogEntryInterface
{
    public function getOrderId(): int;

    public function setOrderId(int $order): void;

    public function getShipmentId(): int;

    public function setShipmentId(int $shipment): void;
}
