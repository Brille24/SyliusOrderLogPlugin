<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class OrderLogEntry extends LogEntry implements OrderLogEntryInterface
{
    /** @var OrderInterface */
    protected $order;

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order): void
    {
        $this->order = $order;
    }
}
