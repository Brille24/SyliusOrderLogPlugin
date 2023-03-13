<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\ShipmentLoggableInterface;

interface ShipmentInterface extends \Sylius\Component\Core\Model\ShipmentInterface, ShipmentLoggableInterface
{

}
