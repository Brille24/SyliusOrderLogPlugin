<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class Shipment extends \Sylius\Component\Core\Model\Shipment implements ShipmentInterface
{
    use ShipmentLoggableTrait;
}
