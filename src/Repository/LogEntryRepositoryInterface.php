<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Repository;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntry;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceLogEntryRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<LogEntry>
 */
interface LogEntryRepositoryInterface extends ResourceLogEntryRepositoryInterface, RepositoryInterface
{
    public function createByOrderIdQueryBuilder(string $orderId): QueryBuilder;
}
