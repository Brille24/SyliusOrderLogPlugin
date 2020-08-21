<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface LoggableInterface
{
    public function getLoggableData(): array;

    public function getLogEntries(): Collection;

    public function setLogEntries(Collection $logEntries): void;
}
