<?php


namespace App\Service\Game;

use App\Entity\Gamee;
use Doctrine\ORM\EntityManagerInterface;

class GameManager {

    private $em;
    /**
     * @param EntityManagerInterface $em
     */
    public function __construct ( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function checkGoles ( Gamee $item )
    {
        if ( $item->getBlueGols() == 1 && $item->getRedGols() == 6 ) {
            $item->setBlueGols( 0 );
            $item->setRedGols( 5 );
            return true;
        } else {
            if ( $item->getBlueGols() == 6 && $item->getRedGols() == 1 ) {
                $item->setBlueGols( 5 );
                $item->setRedGols( 0 );
                return true;
            }
            return false;
        }
    }

    public function checkGames ( Gamee $item )
    {
        if ( $item->getBlueForward()->getname() == $item->getRedForward()->getname() or $item->getBlueForward()->getname() == $item->getRedDefense()->getname() ) {
            return false;
        }
        return true;
    }

    public function parseGames ( array $players ): array
    {
        foreach ($players as $player) {
            $wins = $this->em->getRepository( Gamee::class )->wins_players( $player['id'] );
            $loses = $this->em->getRepository( Gamee::class )->loses_players( $player['id'] );
            $bajadita = $this->em->getRepository( Gamee::class )->bajaditas( $player['id'] );
            $parseGames[$player['name']] = array_merge( $wins, $loses, $bajadita );
        }
        return $parseGames;
    }
}