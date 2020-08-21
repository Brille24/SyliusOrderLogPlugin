<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\OrderLoggableTrait;

class Order extends \Sylius\Component\Core\Model\Order implements OrderInterface
{
    use OrderLoggableTrait;
}
