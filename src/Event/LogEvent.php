<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

abstract class LogEvent extends GenericEvent
{
    /** @var string */
    private $action;

    /** @var array<mixed> */
    private $data;

    /** @var bool */
    private $onlyDifferences;

    public function __construct($subject, string $action, array $data, bool $onlyDifferences = true)
    {
        parent::__construct($subject);

        $this->action = $action;
        $this->data = $data;
        $this->onlyDifferences = $onlyDifferences;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function onlyDifferences(): bool
    {
        return $this->onlyDifferences;
    }
}
