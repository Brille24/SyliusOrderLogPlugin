<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\ShipmentInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLoggableTrait;

class Shipment extends \Sylius\Component\Core\Model\Shipment implements ShipmentInterface
{
    use ShipmentLoggableTrait;
}
