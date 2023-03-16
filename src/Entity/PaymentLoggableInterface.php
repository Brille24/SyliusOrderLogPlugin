<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface PaymentLoggableInterface
{
    public function getLoggableData(): array;
}
