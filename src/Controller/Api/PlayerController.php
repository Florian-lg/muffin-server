<?php


namespace App\Controller\Api;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/new-player")
     * @param Request $request
     * @return View
     */
    public function postNewPlayerAction(Request $request): View
    {
        $player = new Player();
        $player
            ->setDisplayName($request->get('displayName'))
            ->setId($request->get('id'));
        $this->getDoctrine()->getManager()->persist($player);
        $this->getDoctrine()->getManager()->flush();
        return View::create($player, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Post("/game/{id}")
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function postAddPlayerToGame(Request $request, string $id): View
    {
        $player = $this->getDoctrine()->getManager()->getRepository(PlayerRepository::class)->find($id);
        $this->getDoctrine()->getManager()->persist($player);
        return View::create($player, Response::HTTP_CREATED);
    }

}