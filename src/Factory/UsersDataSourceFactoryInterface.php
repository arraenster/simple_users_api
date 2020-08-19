<?php

namespace App\Factory;

use App\DataManager\DataManagerInterface;

interface UsersDataSourceFactoryInterface
{
    /**
     * @param string $dataSource
     * @return DataManagerInterface
     */
    public function getDataManager(string $dataSource = self::DATABASE): DataManagerInterface;
}
