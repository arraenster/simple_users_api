<?php

namespace App\Controller;

use App\Factory\UsersDataSourceFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{

    /**
     * @var UsersDataSourceFactoryInterface
     */
    protected $usersDataSourceFactory;

    function __construct(UsersDataSourceFactoryInterface $usersDataSourceFactory)
    {
        $this->usersDataSourceFactory = $usersDataSourceFactory;
    }

    /**
     * @Route("/api/v1/users/{page<\d+>?1}", methods={"GET"})
     * 
     * @param int $page
     * @return JsonResponse
     */
    public function getList(int $page): JsonResponse
    {
        $dataManager = $this->usersDataSourceFactory->getDataManager();
        $response = $dataManager->getList($page);
;
        return new JsonResponse(['status' => 'OK', 'data' => $response], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/v1/users", methods={"POST"})
     */
    public function create(): JsonResponse
    {
        return new JsonResponse(['status' => 'CREATED', 'data' => []], JsonResponse::HTTP_OK);
    }
}
