<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/new-game")
     * @return View
     */
    public function postNewGameAction(): View
    {
        $game = new Game();
        $this->getDoctrine()->getManager()->persist($game);
        $this->getDoctrine()->getManager()->flush();
        return View::create($game,  Response::HTTP_CREATED);
    }

    /**
     * @Rest\Post("/game-add-player/{id}")
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"game"})
     * @param GameRepository $gameRepository
     * @param PlayerRepository $playerRepository
     * @param Request $request
     * @param string $id
     * @return View
     */
    public function postGameAddPlayer(GameRepository $gameRepository, PlayerRepository $playerRepository, Request $request, string $id): View
    {
        $game = $gameRepository->find($id);
        $player = $playerRepository->find($request->get('playerId'));
        $game->addPlayer($player);
        $this->getDoctrine()->getManager()->persist($game);
        $this->getDoctrine()->getManager()->flush();
        return View::create($game, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/last-game")
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"game"})
     * @param GameRepository $gameRepository
     * @return View
     */
    public function getLastCreatedGame(GameRepository $gameRepository): View
    {
        $game = $gameRepository->findLastGame();
        return new View($game, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/game-players/{id}")
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"game"})
     * @param GameRepository $gameRepository
     * @param string $id
     * @return View
     */
    public function getGamePlayer(GameRepository $gameRepository, string $id): View
    {
        $game = $gameRepository->findPlayersInGame($id);
        return new View($game, Response::HTTP_OK);
    }
}
