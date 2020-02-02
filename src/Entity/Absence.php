<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AbsenceRepository")
 */
class Absence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAbsenceDocument", mappedBy="absence")
     */
    private $userAbsenceDocuments;

    /**
     * Absence constructor.
     */
    public function __construct()
    {
        $this->userAbsenceDocuments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return Absence
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Absence
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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
     * @return Absence
     */
    public function addUserAbsenceDocument(UserAbsenceDocument $userAbsenceDocument): self
    {
        if (!$this->userAbsenceDocuments->contains($userAbsenceDocument)) {
            $this->userAbsenceDocuments[] = $userAbsenceDocument;
            $userAbsenceDocument->setAbsence($this);
        }

        return $this;
    }

    /**
     * @param UserAbsenceDocument $userAbsenceDocument
     * @return Absence
     */
    public function removeUserAbsenceDocument(UserAbsenceDocument $userAbsenceDocument): self
    {
        if ($this->userAbsenceDocuments->contains($userAbsenceDocument)) {
            $this->userAbsenceDocuments->removeElement($userAbsenceDocument);
            // set the owning side to null (unless already changed)
            if ($userAbsenceDocument->getAbsence() === $this) {
                $userAbsenceDocument->setAbsence(null);
            }
        }

        return $this;
    }
}
