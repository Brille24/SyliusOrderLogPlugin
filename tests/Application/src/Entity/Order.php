<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\OrderLoggableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_order')]
class Order extends \Sylius\Component\Core\Model\Order implements OrderInterface
{
    use OrderLoggableTrait;
}
