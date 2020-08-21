<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait ShipmentLoggableTrait
{
    /** @var Collection */
    protected $logEntries;

    public function __construct()
    {
        $this->logEntries = new ArrayCollection();
    }

    public function getLogEntries(): Collection
    {
        return $this->logEntries;
    }

    public function setLogEntries(Collection $logEntries): void
    {
        $this->logEntries = $logEntries;
    }

    public function getLoggableData(): array
    {
        return [
            'state' => $this->getState(),
            'method' => null !== $this->getMethod() ? $this->getMethod()->getCode() : null,
            'tracking' => $this->getTracking(),
        ];
    }
}
