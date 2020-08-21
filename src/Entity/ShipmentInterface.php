<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface ShipmentInterface extends \Sylius\Component\Core\Model\ShipmentInterface, LoggableInterface
{
}
