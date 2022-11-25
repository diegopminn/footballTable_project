<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct ( ManagerRegistry $registry )
    {
        parent::__construct( $registry, Game::class );
    }

    public function add ( Game $entity, bool $flush = false ): void
    {
        $this->getEntityManager()->persist( $entity );

        if ( $flush ) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove ( Game $entity, bool $flush = false ): void
    {
        $this->getEntityManager()->remove( $entity );

        if ( $flush ) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getLastGame ()
    {
        return $this->createQueryBuilder( 'game' )
            ->select( 'game' )
            ->orderBy( 'game.id', 'DESC' )
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
        return $this->createQueryBuilder( 'game' )
            ->select( 'game' )
            ->orderBy( 'game.id', 'DESC' )
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getDates ( \DateTime $StartDate, \DateTime $EndDate )
    {
        return $this->createQueryBuilder( 'game' )
            ->where( 'game.createdAt >= :StartDate ' )
            ->andWhere( 'game.createdAt < :EndDate ' )
            ->orderBy( 'game.createdAt', 'DESC' )
            ->setParameter( 'StartDate', $StartDate )
            ->setParameter( 'EndDate', $EndDate )
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function wins_players ( $player )
    {
        return $this->createQueryBuilder( 'g' )
            ->select( 'COUNT(g) as Victorias' )
            ->where( 'g.blueGols > g.redGols AND (g.blueForward = :player OR g.blueDefense = :player) OR g.blueGols < g.redGols AND (g.redForward = :player OR g.redDefense = :player)' )
            ->setParameter( 'player', $player )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function loses_players ( $player )
    {
        return $this->createQueryBuilder( 'g' )
            ->select( 'COUNT(g) as Derrotas' )
            ->where( 'g.blueGols < g.redGols AND (g.blueForward = :player OR g.blueDefense = :player) OR g.blueGols > g.redGols AND (g.redForward = :player OR g.redDefense = :player)' )
            ->setParameter( 'player', $player )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function bajaditas ( $player )
    {
        return $this->createQueryBuilder( 'g' )
            ->select( 'COUNT(g) as Bajaditas' )
            ->where( 'g.blueGols = 0 AND g.redGols = 7 AND (g.blueForward = :player OR g.blueDefense = :player) OR g.redGols = 0 AND g.blueGols = 7 AND (g.redForward = :player OR g.redDefense = :player)' )
            ->setParameter( 'player', $player )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySomeField ( $value ): ?Game
    {
        return $this->createQueryBuilder( 'g' )
            ->andWhere( 'g.id = :val' )
            ->setParameter( 'val', $value )
            ->getQuery()
            ->getOneOrNullResult();
    }
}
