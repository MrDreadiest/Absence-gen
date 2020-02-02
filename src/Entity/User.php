<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=180, unique=true, name="username")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAbsenceDocument", mappedBy="user")
     */
    private $userAbsenceDocuments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $position;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userAbsenceDocuments = new ArrayCollection();
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return $this
     */
    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Position|null
     */
    public function getPosition(): ?Position
    {
        return $this->position;
    }

    /**
     * @param Position|null $position
     * @return $this
     */
    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|UserAbsenceDocument[]
     */
    public function getUserAbsenceDocuments(): Collection
    {
        return $this->userAbsenceDocuments;
    }

    /**
     * @param UserAbsenceDocument $userAbsenceDocument
     * @return User
     */
    public function addUserAbsenceDocument(UserAbsenceDocument $userAbsenceDocument): self
    {
        if (!$this->userAbsenceDocuments->contains($userAbsenceDocument)) {
            $this->userAbsenceDocuments[] = $userAbsenceDocument;
            $userAbsenceDocument->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserAbsenceDocument $userAbsenceDocument
     * @return User
     */
    public function removeUserAbsenceDocument(UserAbsenceDocument $userAbsenceDocument): self
    {
        if ($this->userAbsenceDocuments->contains($userAbsenceDocument)) {
            $this->userAbsenceDocuments->removeElement($userAbsenceDocument);
            // set the owning side to null (unless already changed)
            if ($userAbsenceDocument->getUser() === $this) {
                $userAbsenceDocument->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }
}
