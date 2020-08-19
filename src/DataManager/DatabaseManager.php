<?php

namespace App\DataManager;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\DTO\UserDto;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DatabaseManager implements DataManagerInterface
{

    protected const AMOUNT_PER_PAGE = 1;

    protected $usersRepository;

    protected $entityManager;

    function __construct(UsersRepository $usersRepository, EntityManager $entityManager)
    {
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $currentPage
     * @return array
     */
    public function getList(int $currentPage = 1): array
    {
        $query = $this->usersRepository->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery();

        $paginator = new Paginator($query);
        $totalItems = count($paginator);

        $totalPages = ceil($totalItems / self::AMOUNT_PER_PAGE);

        $paginator
            ->getQuery()
            ->setFirstResult(self::AMOUNT_PER_PAGE * ($currentPage-1))
            ->setMaxResults(self::AMOUNT_PER_PAGE);

        $usersList = [];
        foreach ($paginator as $user) {
            /** @var Users $user */
            $userDto = new UserDto();
            $userDto->setId($user->getId());
            $userDto->setLogin($user->getLogin());
            $userDto->setCreatedDate($user->getCreatedDate());
            $userDto->setUpdatedDate($user->getUpdatedDate());
            $userDto->setRole($user->getRole());
            $userDto->setStatus($user->getStatus());

            $usersList[] = $userDto->toArray();
        }

        return [
            'users' => $usersList,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ];
    }

    /**
     * @param UserDto $userDto
     * @return UserDto
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(UserDto $userDto): UserDto
    {
        $user = new Users();
        $user->setLogin($userDto->getLogin());
        $user->setPassword($userDto->getPassword());
        $user->setCreatedDate(new \DateTime($userDto->getCreatedDate()));
        $user->setUpdatedDate(new \DateTime($userDto->getUpdatedDate()));
        $user->setRole($userDto->getRole());
        $user->setStatus($userDto->getStatus());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userDto->setId($user->getId());

        return $userDto;
    }
}
