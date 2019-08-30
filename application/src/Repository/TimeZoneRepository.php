<?php

namespace App\Repository;

use App\Common\Repository\AbstractRepository;
use App\Entity\TimeZone;

/**
 * @method TimeZone|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeZone|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeZone[]    findAll()
 * @method TimeZone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeZoneRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return TimeZone::class;
    }
}
