<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{

    protected $id;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    protected $login;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    protected $password;

    /**
     * @Assert\NotBlank
     * @Assert\DateTime
     */
    protected $createdDate;

    /**
     * @Assert\NotBlank
     * @Assert\DateTime
     */
    protected $updatedDate;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    protected $role;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    protected $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param mixed $createdDate
     */
    public function setCreatedDate($createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * @param mixed $updatedDate
     */
    public function setUpdatedDate($updatedDate): void
    {
        $this->updatedDate = $updatedDate;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'createdDate' => $this->createdDate,
            'updatedDate' => $this->updatedDate,
            'role' => $this->role,
            'status' => $this->status,
        ];
    }
}
