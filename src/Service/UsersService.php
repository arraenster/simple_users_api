<?php

namespace App\Service;

use App\Factory\UsersDataSourceFactoryInterface;
use App\DTO\UserDto;

class UsersService implements UserServiceInterface
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
     * @param int $currentPage
     * @param string $source
     * @return array
     */
    public function getList(int $currentPage, string $source): array
    {
        try {
            $dataManager = $this->usersDataSourceFactory->getDataManager($source);
            $response = $dataManager->getList($currentPage);
        } catch (\Exception $e) {
            return [
                'errors' => $e->getMessage()
            ];
        }

        return [ 'data' => $response ];
    }

    /**
     * @param UserDto $userDto
     * @param string $source
     * @return array
     */
    public function createUser(UserDto $userDto, string $source): array
    {
        try {
            $dataManager = $this->usersDataSourceFactory->getDataManager($source);
            $user = $dataManager->create($userDto);
        } catch (\Exception $e) {
            return [
                'errors' => $e->getMessage()
            ];
        }

        return [ 'data' => $user->toArray() ];
    }
}
