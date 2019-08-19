<?php


namespace App\Controller\Api;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Repository\RoleRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory as Faker;

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
     * @Rest\Post("/send-roles")
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"player"})
     * @param Request $request
     * @param PlayerRepository $playerRepository
     * @param RoleRepository $roleRepository
     * @return View
     */
    public function postSetRoleToPlayerAction(Request $request, PlayerRepository $playerRepository, RoleRepository $roleRepository): View
    {
        $player = $playerRepository->find($request->get('playerId'));
        $role = $roleRepository->find(1);
        $player->setRole($role);
        $this->getDoctrine()->getManager()->persist($player);
        $this->getDoctrine()->getManager()->flush();
        return View::create($player, Response::HTTP_CREATED);
    }
}