<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface;

abstract class LogEntry implements LogEntryInterface
{
    /** @var int */
    protected $id;

    /** @var \DateTime */
    protected $date;

    /** @var ?AdminUserInterface */
    protected $user = null;

    /** @var string */
    protected $action = LogEntryInterface::ACTION_CREATE;

    /** @var array<mixed> */
    protected $data = [];

    /** @var mixed */
    protected $objectId = null;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getUser(): ?AdminUserInterface
    {
        return $this->user;
    }

    public function setUser(?AdminUserInterface $user): void
    {
        $this->user = $user;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /** {@inheritdoc} */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /** {@inheritdoc} */
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }
}
