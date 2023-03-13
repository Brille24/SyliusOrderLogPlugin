<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Sylius\Component\Core\Model\OrderInterface;

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
