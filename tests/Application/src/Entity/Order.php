<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Brille24\SyliusOrderLogPlugin\Entity\OrderLoggableTrait;

class Order extends \Sylius\Component\Core\Model\Order implements OrderInterface
{
    use OrderLoggableTrait;
}
