<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\ShipmentLoggableTrait;

class Shipment extends \Sylius\Component\Core\Model\Shipment implements ShipmentInterface
{
    use ShipmentLoggableTrait;
}
