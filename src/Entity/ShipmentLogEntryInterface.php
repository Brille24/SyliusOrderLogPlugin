<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface ShipmentLogEntryInterface
{
    public function getOrder(): OrderInterface;

    public function setOrder(OrderInterface $order): void;

    public function getShipment(): ShipmentInterface;

    public function setShipment(ShipmentInterface $shipment): void;
}
