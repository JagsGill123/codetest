<?php


namespace App\Common\Repository;

use App\Common\Entity\AbstractEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AbstractEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractEntity[]    findAll()
 * @method AbstractEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * AbstractRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }
}
