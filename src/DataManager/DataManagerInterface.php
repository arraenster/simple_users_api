<?php

namespace App\DataManager;

use App\DTO\UserDto;

interface DataManagerInterface
{
    public function getList(int $currentPage = 1): array;

    public function create(UserDto $userDto): UserDto;
}
