<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Validator\UniqueTimeSlot;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date ne peut pas être vide.")]
    #[Assert\GreaterThan("now", message: "La date doit être dans le futur.")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message: "La plage horaire ne peut pas être vide.")]
    #[UniqueTimeSlot]
    private ?string $timeSlot = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'événement ne peut pas être vide.")]
    private ?string $eventName = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTimeSlot(): ?string
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(string $timeSlot): self
    {
        $this->timeSlot = $timeSlot;

        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $now = new \DateTime();
        $interval = $this->date->diff($now);
        if ($interval->days < 1) {
            $context->buildViolation('Les réservations doivent se faire au moins 24 heures à l’avance.')
                ->atPath('date')
                ->addViolation();
        }
    }
}