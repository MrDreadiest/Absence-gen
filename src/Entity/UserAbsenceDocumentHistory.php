<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAbsenceDocumentHistoryRepository")
 */
class UserAbsenceDocumentHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="username")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Absence")
     * @ORM\JoinColumn(nullable=false)
     */
    private $absence;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $createdDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $dateTo;

    /**
     * UserAbsenceDocumentHistory constructor.
     * @param UserAbsenceDocument $userAbsenceDocument
     */
    public function __construct(UserAbsenceDocument $userAbsenceDocument)
    {
        $this->setUser($userAbsenceDocument->getUser());
        $this->setCreatedDate($userAbsenceDocument->getActualDate());
        $this->setAbsence($userAbsenceDocument->getAbsence());
        $this->setDateFrom($userAbsenceDocument->getDateFrom());
        $this->setDateTo($userAbsenceDocument->getDateTo());
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return UserAbsenceDocumentHistory
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Absence|null
     */
    public function getAbsence(): ?Absence
    {
        return $this->absence;
    }

    /**
     * @param Absence|null $absence
     * @return UserAbsenceDocumentHistory
     */
    public function setAbsence(?Absence $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedDate(): ?DateTimeInterface
    {
        return $this->createdDate;
    }

    /**
     * @param DateTimeInterface $createdDate
     * @return UserAbsenceDocumentHistory
     */
    public function setCreatedDate(DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateFrom(): ?DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTimeInterface $dateFrom
     * @return UserAbsenceDocumentHistory
     */
    public function setDateFrom(DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateTo(): ?DateTimeInterface
    {
        return $this->dateTo;
    }

    /**
     * @param DateTimeInterface $dateTo
     * @return UserAbsenceDocumentHistory
     */
    public function setDateTo(DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }
}
