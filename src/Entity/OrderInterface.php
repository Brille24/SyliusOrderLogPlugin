<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface OrderInterface extends \Sylius\Component\Core\Model\OrderInterface, LoggableInterface
{
}
