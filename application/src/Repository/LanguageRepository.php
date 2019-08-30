<?php

namespace App\Repository;

use App\Common\Repository\AbstractRepository;
use App\Entity\CountryCode;
use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Language|null find($id, $lockMode = null, $lockVersion = null)
 * @method Language|null findOneBy(array $criteria, array $orderBy = null)
 * @method Language[]    findAll()
 * @method Language[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return Language::class;
    }
}
