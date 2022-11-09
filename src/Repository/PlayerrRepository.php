<?php

namespace App\Repository;

use App\Entity\Gamee;
use App\Entity\Playerr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Playerr>
 *
 * @method Playerr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playerr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playerr[]    findAll()
 * @method Playerr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playerr::class);
    }

    public function add(Playerr $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Playerr $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllPlayers(): array
    {
        return $this->createQueryBuilder('playerr')
            ->select('playerr.id', 'playerr.Name')
            ->getQuery()
            ->getResult();

    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function wins_loses_players ()
    {
        return $this->createQueryBuilder( 'p' )
            ->select( 'gamee.blueGols')
            ->join(Gamee::class, 'gamee')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Playerr[] Returns an array of Playerr objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Playerr
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
