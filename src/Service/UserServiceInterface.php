<?php

namespace App\Service;

use App\DTO\UserDto;

interface UserServiceInterface
{

    /**
     * @param int $currentPage
     * @param string $source
     * @return array
     */
    public function getList(int $currentPage, string $source): array;

    /**
     * @param UserDto $userDto
     * @param string $source
     * @return array
     */
    public function createUser(UserDto $userDto, string $source): array;
}
