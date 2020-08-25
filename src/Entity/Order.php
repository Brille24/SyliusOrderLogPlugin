<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class Order extends \Sylius\Component\Core\Model\Order implements OrderInterface
{
    use OrderLoggableTrait;
}
