<?php

namespace App\DataManager;

use App\DTO\UserDto;

class XmlManager extends DataManager
{

    public const PATH_TO_FILE = '../var/users.xml';

    /**
     * @param int $currentPage
     * @return array
     */
    public function getList(int $currentPage = 1): array
    {
        if (file_exists(self::PATH_TO_FILE) === false) {
            return [];
        }

        $fileXML = file_get_contents(self::PATH_TO_FILE);
        $usersXML = new \SimpleXMLElement($fileXML);
        $usersList = [];

        $totalItems = count($usersXML);
        $totalPages = ceil($totalItems / self::AMOUNT_PER_PAGE);

        $offset = $currentPage * self::AMOUNT_PER_PAGE;
        $i = 1;
        foreach ($usersXML as $user) {
            $i++;

            if ($i <= $offset) {
                continue;
            }
            if ($i > $offset + self::AMOUNT_PER_PAGE) {
                break;
            }

            $userDto = new UserDto();

            $userDto->setLogin((string)$user->login);
            $userDto->setCreatedDate((string)$user->createdDate);
            $userDto->setUpdatedDate((string)$user->updatedDate);
            $userDto->setRole((string)$user->role);
            $userDto->setStatus((string)$user->status);

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
     */
    public function create(UserDto $userDto): UserDto
    {

        if (file_exists(self::PATH_TO_FILE) === false) {
            $file = fopen(self::PATH_TO_FILE, 'w');

            $users = new \SimpleXMLElement('<users></users>');

            fwrite($file, $users->asXML());
            fclose($file);
        }

        $fileXML = file_get_contents(self::PATH_TO_FILE);
        $usersXml = new \SimpleXMLElement($fileXML);
        $user = $usersXml->addChild('user');
        $user->addChild('login', $userDto->getLogin());
        $user->addChild('password', $userDto->getPassword());
        $user->addChild('createdDate', $userDto->getCreatedDate());
        $user->addChild('updatedDate', $userDto->getUpdatedDate());
        $user->addChild('role', $userDto->getRole());
        $user->addChild('status', $userDto->getStatus());

        file_put_contents(self::PATH_TO_FILE, $usersXml->asXML());

        $userDto->setId('n\a');
        return $userDto;
    }
}
