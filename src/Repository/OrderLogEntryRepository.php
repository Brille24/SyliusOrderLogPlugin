<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class OrderLogEntryRepository extends EntityRepository implements OrderLogEntryRepositoryInterface
{
    public function createByObjectIdQueryBuilder(string $objectId): QueryBuilder
    {
        return $this->createQueryBuilder('log')
            ->where('log.objectId = :objectId')
            ->setParameter('objectId', $objectId)
            ;
    }

    public function createByOrderIdQueryBuilder(string $orderId): QueryBuilder
    {
        return $this->createQueryBuilder('log')
            ->where('log.orderId = :orderId')
            ->setParameter('orderId', $orderId)
            ;
    }
}
