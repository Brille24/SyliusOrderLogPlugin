<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLoggableInterface;
use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLoggableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_shipment')]
class Shipment extends \Sylius\Component\Core\Model\Shipment implements ShipmentLoggableInterface
{
    use ShipmentLoggableTrait;
}
