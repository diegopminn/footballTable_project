<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct ( ManagerRegistry $registry )
    {
        parent::__construct( $registry, Player::class );
    }

    public function add ( Player $entity, bool $flush = false ): void
    {
        $this->getEntityManager()->persist( $entity );

        if ( $flush ) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove ( Player $entity, bool $flush = false ): void
    {
        $this->getEntityManager()->remove( $entity );

        if ( $flush ) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllPlayers (): array
    {
        return $this->createQueryBuilder( 'player' )
            ->select( 'player.id', 'player.name' )
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
            ->select( 'game.blueGols' )
            ->join( Game::class, 'game' )
            ->getQuery()
            ->getResult();
    }

    public function findOneBySomeField ( $value ): ?Player
    {
        return $this->createQueryBuilder( 'p' )
            ->andWhere( 'p.name = :val' )
            ->setParameter( 'val', $value )
            ->getQuery()
            ->getOneOrNullResult();
    }
}
