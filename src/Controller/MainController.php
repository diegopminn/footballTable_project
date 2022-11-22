<?php

namespace App\Controller;

use App\Entity\Gamee;
use App\Entity\Playerr;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function index (): Response
    {
        $players = $this->em->getRepository( Playerr::class )->findAllPlayers();
        $lastGame = $this->em->getRepository( Gamee::class )->getLastGame();
        $gamesperplayer = $this->parseGames( $players );
        $playersname = $this->getPlayersName( $players );
        $game = new Gamee();
        $form = $this->createForm( GameType::class, $game );

        return $this->render( 'frontend/index/index.html.twig', [
            'players' => $players,
            'playersname' => $playersname,
            'formulario' => $form->createView(),
            'lastGame' => $lastGame,
            'games' => $gamesperplayer
        ] );
    }

    /**
     * @Route("/newgame",
     *     options={"expose"=true},
     *     name="app_newgame",
     *     condition="request.isXmlHttpRequest()",
     *     methods = {"POST"}
     * )
     */
    public function ajaxGame ( Request $request, TranslatorInterface $translator, SluggerInterface $slugger ): JsonResponse
    {
        try {
            $item = new Gamee();
            $form = $this->createForm( GameType::class, $item );
            $form->handleRequest( $request );

            if ( $form->isSubmitted() && $form->isValid() ) {
                /** @var Gamee $item */
                $item = $form->getData();
                $file = $form->get( 'file' )->getData();

                if ( !$item->getBlueGols() && !$item->getRedGols() ) {
                    return new JsonResponse( [
                        'status' => 'ko',
                        'message' => $translator->trans( 'swal.error_gol' )
                    ] );
                } else {
                    if ( !$this->checkNames( $item ) ) {
                        return new JsonResponse( [
                            'status' => 'ko',
                            'message' => $translator->trans( 'swal.error_norepeat' )
                        ] );
                    } else {
                        if ( $this->checkGoles( $item ) ) {
                            $this->em->persist( $item );
                            $this->em->flush();
                            return new JsonResponse( [
                                'status' => 'ok',
                                'item_id' => $item->getId(),
                            ] );
                        } else {
                            if ( $file ) {
                                $originalFilename = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                                $safeFilename = $slugger->slug( $originalFilename );
                                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                                try {
                                    $file->move(
                                        $this->getParameter( 'files_directory' ),
                                        $newFilename
                                    );
                                    $item->setFile( $newFilename );
                                    $this->em->persist( $item );
                                    $this->em->flush();
                                    return new JsonResponse( [
                                        'status' => 'ok',
                                        'item_id' => $item->getId(),
                                    ] );
                                } catch (FileException $e) {
                                    return new JsonResponse( [
                                        'status' => 'ko',
                                        'message' => $translator->trans( 'swal.error_file' )
                                    ] );
                                }
                            }
                        }
                    }
                }
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

    private function getPlayersName ( array $playerss ): array
    {
        $zoosName = [];
        foreach ($playerss as $playurs) {
            $zoosName[$playurs['id']] = $playurs['name'];
        }
        return $zoosName;
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

    private function checkNames ( Gamee $item )
    {
        if ( $item->getBlueForward()->getname() == $item->getRedForward()->getname() or $item->getBlueForward()->getname() == $item->getRedDefense()->getname() ) {
            return false;
        }
        return true;
    }

    private function checkGoles ( Gamee $item )
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
}
