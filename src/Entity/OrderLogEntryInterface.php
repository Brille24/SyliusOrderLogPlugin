<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface OrderLogEntryInterface extends LogEntryInterface
{
    public function getOrder(): OrderInterface;

    public function setOrder(OrderInterface $order): void;
}
