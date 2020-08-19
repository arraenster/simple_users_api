<?php

namespace App\Controller;

use App\DTO\UserDto;
use App\Entity\Users;
use App\Factory\UsersDataSourceFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolation;

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
        return new JsonResponse(['status' => JsonResponse::HTTP_OK, 'data' => $response], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/v1/users", methods={"POST"})
     */
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        $this->usersDataSourceFactory->setEntityManager($this->getDoctrine()->getManager());

        $userDto = new UserDto();
        $userDto->setLogin($request->request->get('login'));
        $userDto->setPassword($request->request->get('password'));
        $userDto->setCreatedDate($request->request->get('createdDate'));
        $userDto->setUpdatedDate($request->request->get('updatedDate'));
        $userDto->setRole((int)$request->request->get('role'));
        $userDto->setStatus((int)$request->request->get('status'));

        $errors = $validator->validate($userDto);
        if (count($errors) > 0) {

            $parsedErrors = [];
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */

                $parsedErrors[] = [
                    $error->getPropertyPath() => $error->getMessage()
                ];
            }
            return new JsonResponse(['status' => JsonResponse::HTTP_BAD_REQUEST, 'errors' => $parsedErrors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $dataManager = $this->usersDataSourceFactory->getDataManager();
        $user = $dataManager->create($userDto);

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'data' => $user->toArray()], JsonResponse::HTTP_CREATED);
    }
}
