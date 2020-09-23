<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Service\GameStart;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    var $userID = 343;
    /**
     * @Route("/", name="game_index", methods={"GET"})
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="game_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository, GameStart $gameStart,  GameRepository $gameRepository): Response
    {    
        // Récuperartion User
        $user = $userRepository->findOneById($this->userID); 
        // Verification si la partie existe deja
        $gameIsActive = $gameStart->gameIsExist($user);

        // Si une partie n'existe pas on l'as créer
        if($gameIsActive === 1 ) {
            $game = new Game();
            // Ajout de user
            $game->setUser($user);
    
            $form = $this->createForm(GameType::class, $game);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                // AJOUTER ID GAME a la table user
                $user->setGame($game);
                // Ajout Game
                $entityManager->persist($game);
                $entityManager->flush();
                return $this->redirectToRoute('game_index');
            }
    
            return $this->render('game/new.html.twig', [
                'game' => $game,
                'form' => $form->createView(),
            ]);
        // Si la partie existe
        } elseif ($gameIsActive === 2 ) {
            $gameByUser = $user->getGame();

            // return form reprendre la partie ou nouvelle partie
            return $this->render('game/takeOrDelete.html.twig',[
                'game' => $gameRepository->findOneById($gameByUser),
            ]);
        }


    }

    /**
     * @Route("/{id}", name="game_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_delete", methods={"DELETE"})
     * Cette fonciton permet de suprimer un game et mettre à jour la table user
     * Elle redirige vers la creation d'un nouveau game
     */
    public function delete(Request $request, Game $game, UserRepository $userRepository ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            // Mise a jour de gmae id chez user
            $entityManager = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneById($this->userID); 
            $user->setGame(null);
            $entityManager->persist($user);
            $entityManager->flush();

            // // Supression du game
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->remove($game);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_new');
    }
}
