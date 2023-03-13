<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface ShipmentLoggableInterface
{
    public function getLoggableData(): array;
}
