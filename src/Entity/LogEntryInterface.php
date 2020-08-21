<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface LogEntryInterface extends ResourceInterface
{
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    public function getDate(): \DateTime;

    public function setDate(\DateTime $date): void;

    public function getUser(): AdminUserInterface;

    public function setUser(AdminUserInterface $user): void;

    public function getAction(): string;

    public function setAction(string $action): void;

    public function getData(): array;

    public function setData(array $data): void;
}
