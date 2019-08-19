<?php

namespace App\Controller\Api;

use App\Repository\RoleRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use http\Env\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/role/{id}")
     * @param RoleRepository $roleRepository
     * @param int $id
     * @return View
     */
    public function getRoleAction(RoleRepository $roleRepository, int $id): View
    {
        $role = $roleRepository->find($id);
        return new View($role, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/roles")
     * @param RoleRepository $roleRepository
     * @return View
     */
    public function getRolesAction(RoleRepository $roleRepository): View
    {
        $roles = $roleRepository->findAll();
        return new View($roles, Response::HTTP_OK);
    }
}
