<?php

namespace App\Factory;

use App\DataManager\DatabaseManager;
use App\DataManager\DataManagerInterface;
use App\DataManager\XmlManager;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ObjectManager;

class UsersDataSourceFactory implements UsersDataSourceFactoryInterface
{

    public const DATABASE = "database";
    public const XML = "xml";

    protected $usersRepository;

    protected $entityManager;

    function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function setEntityManager(ObjectManager $em)
    {
        $this->entityManager = $em;
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
                return new DatabaseManager($this->usersRepository, $this->entityManager);
                break;
        }
    }
}

