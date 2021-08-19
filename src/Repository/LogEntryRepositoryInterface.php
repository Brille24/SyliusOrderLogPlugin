<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceLogEntryRepositoryInterface;

interface LogEntryRepositoryInterface extends ResourceLogEntryRepositoryInterface
{
    public function createByOrderIdQueryBuilder(string $objectId): QueryBuilder;
}
