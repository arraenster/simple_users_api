<?php

namespace App\Factory;

use App\DataManager\DatabaseManager;
use App\DataManager\DataManagerInterface;
use App\DataManager\XmlManager;
use App\Repository\UsersRepository;

class UsersDataSourceFactory implements UsersDataSourceFactoryInterface
{

    public const DATABASE = "database";
    public const XML = "xml";

    protected $usersRepository;

    function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function getDataManager(string $dataSource = self::DATABASE): DataManagerInterface
    {
        switch ($dataSource)
        {
            case self::XML:
                return new XmlManager();
                break;
            case self::DATABASE:
            default:
                return new DatabaseManager($this->usersRepository);
                break;
        }

    }
}

