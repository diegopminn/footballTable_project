<?php

namespace App\Controller;

use App\Entity\Gamee;
use App\Entity\Playerr;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct ( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="app_main")
     */
    public function index(Request $request): Response
    {
        $players = $this->em->getRepository(Playerr::class)->findAllPlayers();
        $lastGame = $this->em->getRepository(Gamee::class)->getLastGame();
        $gamesperplayer =$this->parseGames($players);
        $playersname = $this->getplayersname($players);
        $game = new Gamee();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($game);
            $this->em->flush();
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/index.html.twig', [
            'players' => $players,
            'playersname' => $playersname,
            'formulario' => $form->createView(),
            'lastGame' => $lastGame,
            'games' => $gamesperplayer
          //  'bajaditas' => $bajadita
        ]);

    }

    /**
     * @Route("/games", name="app_games")
     */
    public function games(Request $request): Response
    {
        $lastsGame = $this->em->getRepository(Gamee::class)->getLastsGame();
        return $this->render('main/games.html.twig', [
            'lastsGame' => $lastsGame
        ]);
    }

    /**
     * @Route("/players", name="app_players")
     */
    public function players(): Response
    {
        $players = $this->em->getRepository(Playerr::class)->findAllPlayers();
        $gamesperplayer =$this->parseGames($players);
        return $this->render('main/players.html.twig', [
            'players' => $players,
            'totalgames' => $gamesperplayer
        ] );
    }

    private function getplayersname (array $playerss)
    {
        $zoosName = [];
        foreach ($playerss as $playurs) {
            $zoosName[$playurs['id']] = $playurs['Name'];
        }
        return $zoosName;
    }

    private function parseGames(array $players): array
    {
        foreach ($players as $player){
            $wins = $this->em->getRepository(Gamee::class)->wins_players($player['id']);
            $loses = $this->em->getRepository(Gamee::class)->loses_players($player['id']);
            $bajadita = $this->em->getRepository(Gamee::class)->bajaditas($player['id']);
            $parseGames[$player['Name']] = array_merge($wins, $loses, $bajadita);
        }
        return $parseGames;
    }


}
