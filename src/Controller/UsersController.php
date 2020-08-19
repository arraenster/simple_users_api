<?php

namespace App\Controller;

use App\DTO\UserDto;
use App\Entity\Users;
use App\Factory\UsersDataSourceFactory;
use App\Factory\UsersDataSourceFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

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
     * @SWG\Response(
     *     response=200,
     *     description="Returns list of users",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=UserDto::class, groups={"full"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="source",
     *     in="query",
     *     type="string",
     *     description="Switcher for data source (xml, database)"
     * )
     * @param int $page
     * @return JsonResponse
     */
    public function getList(int $page, Request $request): JsonResponse
    {
        if (!in_array(
            $request->query->get('source'),
            [
                UsersDataSourceFactory::XML,
                UsersDataSourceFactory::DATABASE
            ]
        )) {
            return new JsonResponse(['status' => JsonResponse::HTTP_BAD_REQUEST, 'errors' => [
                0 => ['source' => 'Allowed data source is xml or database.']]], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->usersDataSourceFactory->setEntityManager($this->getDoctrine()->getManager());
        $dataSource = $request->query->get('source');

        $dataManager = $this->usersDataSourceFactory->getDataManager($dataSource);
        $response = $dataManager->getList($page);
;
        return new JsonResponse(['status' => JsonResponse::HTTP_OK, 'data' => $response], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/v1/users", methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="Creates one user",
     *     @Model(type=UserDto::class)
     * )
     * @SWG\Parameter(
     *     name="source",
     *     in="query",
     *     type="string",
     *     description="Switcher for data source (xml, database)"
     * )
     */
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        if (!in_array(
            $request->query->get('source'),
            [
                UsersDataSourceFactory::XML,
                UsersDataSourceFactory::DATABASE
            ]
        )) {
            return new JsonResponse(['status' => JsonResponse::HTTP_BAD_REQUEST, 'errors' => [
                'source' => 'Allowed data source is xml or database.']], JsonResponse::HTTP_BAD_REQUEST);
        }

        $dataSource = $request->query->get('source');

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

        $dataManager = $this->usersDataSourceFactory->getDataManager($dataSource);
        $user = $dataManager->create($userDto);

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'data' => $user->toArray()], JsonResponse::HTTP_CREATED);
    }
}
