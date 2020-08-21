<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface LoggableInterface
{
    public function getLoggableData(): array;
}
