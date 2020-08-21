<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface OrderLogEntryInterface extends LogEntryInterface
{
    public function getOrder(): OrderInterface;

    public function setOrder(OrderInterface $order): void;
}
