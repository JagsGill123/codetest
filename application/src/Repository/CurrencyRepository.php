<?php

namespace App\Repository;

use App\Common\Repository\AbstractRepository;
use App\Entity\Country;
use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return Currency::class;
    }
}
