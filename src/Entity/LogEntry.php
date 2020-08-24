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

    /** @var AdminUserInterface */
    protected $user;

    /** @var string */
    protected $action;

    /** @var array<mixed> */
    protected $data;

    /** @var int */
    protected $objectId;

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

    public function getUser(): AdminUserInterface
    {
        return $this->user;
    }

    public function setUser(AdminUserInterface $user): void
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

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): void
    {
        $this->objectId = $objectId;
    }
}
