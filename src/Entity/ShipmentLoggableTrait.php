<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

trait ShipmentLoggableTrait
{
    public function getLoggableData(): array
    {
        return [
            'state' => $this->getState(),
            'method' => null !== $this->getMethod() ? $this->getMethod()->getCode() : null,
            'tracking' => $this->getTracking(),
        ];
    }
}
