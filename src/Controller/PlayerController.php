<?php

namespace App\Controller;

use App\Entity\Gamee;
use App\Entity\Playerr;
use App\Form\GameType;
use App\Form\PlayerType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class PlayerController extends AbstractController
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
     * @Route("/players", name="app_players")
     */
    public function player (): Response
    {
        $players = $this->em->getRepository( Playerr::class )->findAllPlayers();
        $gamesperplayer = $this->parseGames( $players );
        $newPlayer = new Playerr();
        $form = $this->createForm( PlayerType::class, $newPlayer );

        return $this->render( 'frontend/players/players.html.twig', [
            'players' => $players,
            'form' => $form->createView(),
            'totalgames' => $gamesperplayer
        ] );
    }

    /**
     * @Route("/players/newPlayer",
     *     options={"expose"=true},
     *     name="app_new_player",
     *     condition="request.isXmlHttpRequest()",
     *     methods = {"POST"}
     *     )
     */
    public function newPlayer ( Request $request ): JsonResponse
    {
        try {
            $item = new Playerr();
            $form = $this->createForm( PlayerType::class, $item );
            $form->handleRequest( $request );

            if ( $form->isSubmitted() && $form->isValid() ) {
                /** @var Playerr $item */
                $item = $form->getData();

                $this->em->persist( $item );
                $this->em->flush();
                return new JsonResponse( [
                    'status' => 'ok',
                    'item_id' => $item->getId(),
                ] );
            }
            return new JsonResponse( [
                'status' => 'ko',
                'messages' => 'No valid form'
            ] );
        } catch (Exception $e) {
            return new JsonResponse( [
                'status' => 'error',
                'messages' => 'El formulario no es valido',
            ] );
        }
    }

    /**
     * @Route("/players/delete/{name}",
     *     name="app_delete_player",
     *     options={"expose"=true},
     *     condition="request.isXmlHttpRequest()",
     *     methods = {"POST"})
     */
    public function deletePlayer ( string $name ): JsonResponse
    {
        try {
            $item = $this->em->getRepository( Playerr::class )->findOneBySomeField( $name );
            $this->em->remove( $item );
            $this->em->flush();
            return new JsonResponse(
                ['status' => 'ok',
                $this->redirectToRoute( 'app_players' )
                ]);
        } catch (Exception $e) {
            return new JsonResponse( [
                'status' => 'error',
                'messages' => 'El formulario no es valido',
            ] );
        }
    }

    private function parseGames ( array $players ): array
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
