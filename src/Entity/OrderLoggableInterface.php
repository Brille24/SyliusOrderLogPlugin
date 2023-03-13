<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface OrderLoggableInterface
{
    public function getLoggableData(): array;
}
