<?php


namespace App\Model\User;


use App\Entity\Department;
use App\Entity\Position;
use App\Entity\User;

/**
 * Class EditUser
 * @package App\Model\User
 */
class EditUser
{
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var
     */
    private $password;

    /**
     * @var Department
     */
    private $department;

    /**
     * @var Position
     */
    private $position;

    /**
     * EditUser constructor.
     * @param User|null $user
     */
    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
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
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Department $department
     */
    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }
}