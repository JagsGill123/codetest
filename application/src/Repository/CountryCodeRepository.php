<?php

namespace App\Repository;

use App\Common\Repository\AbstractRepository;
use App\Entity\CountryCode;

/**
 * @method CountryCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryCode[]    findAll()
 * @method CountryCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryCodeRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return CountryCode::class;
    }
}
