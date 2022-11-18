<?php

namespace App\Repository;

use App\Entity\Gamee;
use App\Entity\Playerr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gamee>
 *
 * @method Gamee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gamee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gamee[]    findAll()
 * @method Gamee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gamee::class);
    }

    public function add(Gamee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gamee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getLastGame ()
    {
        return $this->createQueryBuilder( 'gamee' )
            ->select( 'gamee' )
            ->orderBy( 'gamee.id', 'DESC' )
            ->setMaxResults( 1 )
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getLastsGame ()
    {
        return $this->createQueryBuilder( 'gamee' )
            ->select( 'gamee' )
            ->orderBy( 'gamee.id', 'DESC' )
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function wins_players ($player)
    {
        return $this->createQueryBuilder( 'g' )
            ->select('COUNT(g) as Victorias')
            ->where('g.blueGols > g.redGols AND (g.blueForward = :player OR g.blueDefense = :player) OR g.blueGols < g.redGols AND (g.redForward = :player OR g.redDefense = :player)')
            ->setParameter('player', $player)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function loses_players ($player)
    {
        return $this->createQueryBuilder( 'g' )
            ->select('COUNT(g) as Derrotas')
            ->where('g.blueGols < g.redGols AND (g.blueForward = :player OR g.blueDefense = :player) OR g.blueGols > g.redGols AND (g.redForward = :player OR g.redDefense = :player)')
            ->setParameter('player', $player)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function bajaditas ($player)
    {
        return $this->createQueryBuilder( 'g' )
            ->select('COUNT(g) as Bajaditas')
            ->where('g.blueGols = 0 AND g.redGols = 7 AND (g.blueForward = :player OR g.blueDefense = :player) OR g.redGols = 0 AND g.blueGols = 7 AND (g.redForward = :player OR g.redDefense = :player)')
            ->setParameter('player', $player)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Gamee[] Returns an array of Gamee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneBySomeField($value): ?Gamee
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
