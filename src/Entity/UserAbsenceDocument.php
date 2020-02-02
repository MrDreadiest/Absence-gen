<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAbsenceDocumentRepository")
 */
class UserAbsenceDocument
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userAbsenceDocuments")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="username")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Absence", inversedBy="userAbsenceDocuments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $absence;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $actualDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual("today", message="Date from should be today or in the future!")
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today", message="Date to must be set for today or future.")
     * Assert\Expression(
     *     "this.getDateTo() > this.getDateFrom()",
     *     message="The date to must be gather than date from!")
     */
    private $dateTo;

    /**
     * UserAbsenceDocument constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->setActualDate(new DateTime());
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
     * @return UserAbsenceDocument
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
     * @return UserAbsenceDocument
     */
    public function setAbsence(?Absence $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getActualDate(): ?DateTimeInterface
    {
        return $this->actualDate;
    }

    /**
     * @param DateTimeInterface $actualDate
     * @return UserAbsenceDocument
     */
    public function setActualDate(DateTimeInterface $actualDate): self
    {
        $this->actualDate = $actualDate;

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
     * @return UserAbsenceDocument
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
     * @return UserAbsenceDocument
     */
    public function setDateTo(DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }
}
