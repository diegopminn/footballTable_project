<?php


namespace App\Service\Game;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class GameManager
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct ( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function convertSixOneToFiveCero ( Game $item )
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

    public function checkGames ( Game $item )
    {
        if ( $item->getBlueForward()->getname() == $item->getRedForward()->getname() or $item->getBlueForward()->getname() == $item->getRedDefense()->getname() or
            $item->getBlueDefense()->getname() == $item->getRedForward()->getname() or $item->getBlueDefense()->getname() == $item->getRedDefense()->getname()) {
            return false;
        }
        return true;
    }

    public function checkIfSevenCero ( Game $item )
    {
        if ( $item->getBlueGols() == 7 || $item->getRedGols() == 7 ) {
            return true;
        }
        return false;
    }

    public function parseGames ( array $players ): array
    {
        foreach ($players as $player) {
            $wins = $this->em->getRepository( Game::class )->wins_players( $player['id'] );
            $loses = $this->em->getRepository( Game::class )->loses_players( $player['id'] );
            $bajadita = $this->em->getRepository( Game::class )->bajaditas( $player['id'] );
            $parseGames[$player['name']] = array_merge( $wins, $loses, $bajadita );
        }
        return $parseGames;
    }
}