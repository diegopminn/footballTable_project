<?php

namespace App\Controller;

use App\Entity\Gamee;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class GameController extends AbstractController
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
     * @Route("/games", name="app_games")
     */
    public function games ( Request $request, PaginatorInterface $paginator ): Response
    {
        $lastsGames = $this->em->getRepository( Gamee::class )->getLastsGame();
        $form = $this->createForm( GameType::class );
        $games = $paginator->paginate(
            $lastsGames, /* query NOT result */
            $request->query->getInt( 'page', 1 ), /*page number*/
            12 /*limit per page*/
        );
        return $this->render( 'frontend/games/games.html.twig', [
            'games' => $games,
            'form' => $form->createView()
        ] );
    }

    /**
     * @Route("/games/update/{id}",
     *     name="app_update_game",
     *     options={"expose"=true},
     *     condition="request.isXmlHttpRequest()",
     *     methods = {"POST"})
     */
    public function updateGame ( Request $request, TranslatorInterface $translator, $id ): JsonResponse
    {
        try {
            $item = $this->em->getRepository( Gamee::class )->findOneBySomeField( $id );
            $form = $this->createForm( GameType::class, $item );
            $form->handleRequest( $request );
            if ( $form->isSubmitted() && $form->isValid() ) {

                if ( !$item->getBlueGols() && !$item->getRedGols() ) {
                    return new JsonResponse( [
                        'status' => 'ko',
                        'message' => $translator->trans( 'swal.error_gol' )
                    ] );
                } else {
                    if ( !$this->checkGames( $item ) ) {
                        return new JsonResponse( [
                            'status' => 'ko',
                            'message' => $translator->trans( 'swal.error_norepeat' )
                        ] );
                    } else {
                        if ( $this->checkGoles( $item ) ) {
                            $this->em->flush();
                            return new JsonResponse( [
                                'status' => 'ok',
                                'item_id' => $item->getId(),
                            ] );
                        }
                        $this->em->flush();
                        return new JsonResponse( [
                            'status' => 'ok',
                            'item_id' => $item->getId(),
                        ] );
                    }
                }
            } else {
                return new JsonResponse( [
                    'status' => 'ko',
                    'messages' => 'No valid form'
                ] );
            }
        } catch (Exception $e) {
            return new JsonResponse( [
                'status' => 'error',
                'messages' => 'El formulario no es valido',
            ] );
        }
    }

    /**
     * @Route("/games/delete/{id}",
     *     name="app_delete_game",
     *     options={"expose"=true},
     *     condition="request.isXmlHttpRequest()",
     *     methods = {"POST"})
     */
    public function deleteGame ( $id ): JsonResponse
    {
        try {
            $item = $this->em->getRepository( Gamee::class )->findOneBySomeField( $id );
            $this->em->remove( $item );
            $this->em->flush();
            return new JsonResponse(
                [ 'status' => 'ok',
                    $this->redirectToRoute( 'app_games' )
                ] );
        } catch (Exception $e) {
            return new JsonResponse( [
                'status' => 'error',
                'messages' => 'El formulario no es valido',
            ] );
        }
    }

    private function checkGames ( Gamee $item )
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
