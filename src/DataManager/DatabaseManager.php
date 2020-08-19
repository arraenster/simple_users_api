<?php

namespace App\DataManager;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\DTO\UserDto;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DatabaseManager implements DataManagerInterface
{

    protected const AMOUNT_PER_PAGE = 1;

    protected $usersRepository;

    function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function getList(int $currentPage = 1)
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

        $userList = [];
        foreach ($paginator as $user) {
            /** @var Users $user */
            $userDto = new UserDto();
            $userDto->setId($user->getId());
            $userDto->setLogin($user->getLogin());
            $userDto->setCreatedDate($user->getCreatedDate());
            $userDto->setUpdatedDate($user->getUpdatedDate());
            $userDto->setRole($user->getRole());
            $userDto->setStatus($user->getStatus());

            $userList[] = $userDto->toArray();
        }

        return [
            'users' => $userList,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ];
    }
}
