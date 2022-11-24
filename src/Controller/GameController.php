<?php

namespace App\Controller;

use App\Entity\Gamee;
use App\Form\GameType;
use App\Service\Game\GameManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class GameController extends AbstractController
{
    private $em;

    protected GameManager $gameManager;

    /**
     * @param EntityManagerInterface $em
     * @param GameManager $gameManager
     */
    public function __construct ( EntityManagerInterface $em, GameManager $gameManager )
    {
        $this->em = $em;
        $this->gameManager = $gameManager;
    }

    /**
     * @Route("/games", name="app_games")
     */
    public function games ( Request $request, PaginatorInterface $paginator, ?string $year = null ): Response
    {
        $lastsGames = $this->em->getRepository( Gamee::class )->getLastsGame();
        $form = $this->createForm( GameType::class );
        if ( $year ) {
            $currentYear = $year;
        } else {
            $currentYear = (new \DateTimeImmutable())->format( 'Y' );
        }
        $games = $paginator->paginate(
            $lastsGames, /* query NOT result */
            $request->query->getInt( 'page', 1 ), /*page number*/
            12 /*limit per page*/
        );
        return $this->render( 'frontend/games/games.html.twig', [
            'games' => $games,
            'form' => $form->createView(),
            'currentYear' => $currentYear
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
            $file = $form->get( 'file' )->getData();

            if ( !$form->isSubmitted() || !$form->isValid() ) {
                return new JsonResponse( [
                    'status' => 'ko',
                    'messages' => 'No valid form'
                ] );
            }

            if ( !$item->getBlueGols() && !$item->getRedGols() ) {
                return new JsonResponse( [
                    'status' => 'ko',
                    'message' => $translator->trans( 'swal.error_gol' )
                ] );
            }

            if ( !$this->gameManager->checkGames( $item ) ) {
                return new JsonResponse( [
                    'status' => 'ko',
                    'message' => $translator->trans( 'swal.error_norepeat' )
                ] );
            }

            if ( $this->gameManager->convertSixOneToFiveCero( $item ) ) {
                $this->em->persist( $item );
                $this->em->flush();
                return new JsonResponse( [
                    'status' => 'ok',
                    'item_id' => $item->getId(),
                ] );
            }
            if ( $this->gameManager->checkIfSevenCero( $item ) ) {
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
                } else {
                    $this->em->persist( $item );
                    $this->em->flush();
                    return new JsonResponse( [
                        'status' => 'ok',
                        'item_id' => $item->getId(),
                    ] );
                }
            } else {
                $this->em->persist( $item );
                $this->em->flush();
                return new JsonResponse( [
                    'status' => 'ok',
                    'item_id' => $item->getId(),
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
     * @Route("/games/season/{year}/{startMonth}-{endMonth}", name="app_games_seasons")
     * @throws Exception
     */
    public function gamesSeason ( Request $request, PaginatorInterface $paginator, string $year, string $startMonth, string $endMonth ): Response
    {
        $form = $this->createForm( GameType::class );
        $startDate = (new \DateTime( $year . "-" . $startMonth ))->modify( 'first day of this month 00:00:00' );
        $endDate = (new \DateTime( $year . "-" . $endMonth ))->modify( 'last day of this month 23:59:59' );
        $query = $this->em->getRepository( Gamee::class )->getDates( $startDate, $endDate );
        if ( $year ) {
            $currentYear = $year;
        } else {
            $currentYear = (new \DateTimeImmutable())->format( 'Y' );
        }

        $games = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt( 'page', 1 ), /*page number*/
            12 /*limit per page*/
        );
        return $this->render( 'frontend/games/games.html.twig', [
            'games' => $games,
            'currentYear' => $currentYear,
            'startMonth' => $startMonth,
            'endMonth' => $endMonth,
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
                }
                if ( !$this->gameManager->checkGames( $item ) ) {
                    return new JsonResponse( [
                        'status' => 'ko',
                        'message' => $translator->trans( 'swal.error_norepeat' )
                    ] );
                }
                if ( $this->gameManager->convertSixOneToFiveCero( $item ) ) {
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
}
