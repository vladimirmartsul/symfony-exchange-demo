<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Pair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pair|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pair|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pair[]    findAll()
 * @method Pair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pair::class);
    }


    /**
     * Есть ли искомое значение в указанном поле
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function isFieldValueExist(string $field, string $value): bool
    {
        return $this->createQueryBuilder('p')
                ->select('COUNT(1)')
                ->andWhere("p.{$field} = :value")
                ->setParameter('value', $value)
                ->getQuery()
                ->getSingleScalarResult()
            > 0;
    }
}
