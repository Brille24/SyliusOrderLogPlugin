<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Event;

use Brille24\SyliusOrderLogPlugin\Entity\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

abstract class LogEvent extends GenericEvent
{
    /** @var string */
    private $action;

    /** @var array<mixed> */
    private $data;

    public function __construct(OrderInterface $subject, string $action, array $data)
    {
        parent::__construct($subject);

        $this->action = $action;
        $this->data = $data;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
