<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;

class OrderLogEvent extends LogEvent
{
    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getOrder(): OrderInterface
    {
        return $this->getSubject();
    }
}
