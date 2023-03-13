<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\OrderLoggableInterface;

interface OrderInterface extends \Sylius\Component\Core\Model\OrderInterface, OrderLoggableInterface
{

}
