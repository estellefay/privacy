<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    var $userID = 50;
    /**
     * @Route("/", name="player_user_show", methods={"GET"})
     */
    public function showAll(PlayerRepository $playerRepository, UserRepository $userRepository, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Player::class);

        // Recup player d'un user
        $players = $repository->findBy(
            array('user' => $this->userID),
        );

        // // recup User 
        // $user = $userRepository->findOneById(50);


        // create form for new player ( MODAL )
        $player = new Player();
        //$player->setUser($user);
        $form = $this->createForm(PlayerType::class, $player );
        $form->handleRequest($request);


        return $this->render('user/player/show.html.twig', [
            'players' => $repository->findBy(array('user' => $this->userID)),
            'form' => $form->createView(),
        ]);
    }
    
    // /**
    //  * @Route("/all", name="player_index", methods={"GET"})
    //  */
    // public function index(PlayerRepository $playerRepository): Response
    // {
    //     return $this->render('admin/player/index.html.twig', [
    //         'players' => $playerRepository->findAll(),
    //     ]);
    // }

    /**
     * @Route("/new", name="player_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        // Récuperartion User
        $user = $userRepository->findOneById($this->userID);  
        // Creation new formulaire 
        $player = new Player();
        // Ajout de user
        $player->setUser($user);
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($player);
            $entityManager->flush();
            return $this->redirectToRoute('player_user_show');
        }

        return $this->render('user/player/new.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_show", methods={"GET"})
     */
    public function show(Player $player): Response
    {
        return $this->render('admin/player/show.html.twig', [
            'player' => $player,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="player_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Player $player): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('admin/player/edit.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Player $player): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($player);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_index');
    }
}
