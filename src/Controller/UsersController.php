<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{

    /**
     * @Route("/api/v1/users", methods={"GET"})
     */
    public function getList(): JsonResponse
    {
        return new JsonResponse(['status' => 'OK', 'data' => []], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/v1/users", methods={"POST"})
     */
    public function create(): JsonResponse
    {
        return new JsonResponse(['status' => 'CREATED', 'data' => []], JsonResponse::HTTP_OK);
    }
}
