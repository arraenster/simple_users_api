<?php

namespace App\Factory;

use App\DataManager\DatabaseManager;
use App\DataManager\DatabaseManagerInterface;
use App\DataManager\DataManagerInterface;
use App\DataManager\XmlManager;
use App\DataManager\XmlManagerInterface;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ObjectManager;

class UsersDataSourceFactory implements UsersDataSourceFactoryInterface
{

    public const DATABASE = "database";
    public const XML = "xml";

    /**
     * @var XmlManager
     */
    protected $xmlManager;

    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    function __construct(XmlManagerInterface $xmlManager, DatabaseManagerInterface $databaseManager)
    {
        $this->xmlManager = $xmlManager;
        $this->databaseManager = $databaseManager;
    }

    public function getDataManager(string $dataSource = self::DATABASE): DataManagerInterface
    {
        switch ($dataSource)
        {
            case self::XML:
                return $this->xmlManager;
                break;
            case self::DATABASE:
            default:
                return $this->databaseManager;
                break;
        }
    }
}

