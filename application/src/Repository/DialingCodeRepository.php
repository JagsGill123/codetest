<?php

namespace App\Repository;

use App\Common\Repository\AbstractRepository;
use App\Entity\DialingCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DialingCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method DialingCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method DialingCode[]    findAll()
 * @method DialingCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DialingCodeRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return DialingCode::class;
    }
}
