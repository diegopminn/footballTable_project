<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Form\GameType;
use App\Service\Game\GameManager;
use App\Service\Player\PlayerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $em;

    protected GameManager $gameManager;

    protected PlayerManager $playerManager;

    /**
     * @param EntityManagerInterface $em
     * @param GameManager $gameManager
     * @param PlayerManager $playerManager
     */
    public function __construct ( EntityManagerInterface $em, GameManager $gameManager, PlayerManager $playerManager )
    {
        $this->em = $em;
        $this->gameManager = $gameManager;
        $this->playerManager = $playerManager;
    }

    /**
     * @Route("/", name="app_main")
     */
    public function index (): Response
    {
        $players = $this->em->getRepository( Player::class )->findAllPlayers();
        $lastGame = $this->em->getRepository( Game::class )->getLastGame();
        $gamesPerPlayer = $this->gameManager->parseGames( $players );
        $game = new Game();
        $form = $this->createForm( GameType::class, $game );

        return $this->render( 'frontend/index/index.html.twig', [
            'formulario' => $form->createView(),
            'lastGame' => $lastGame,
            'games' => $gamesPerPlayer
        ] );
    }
}
