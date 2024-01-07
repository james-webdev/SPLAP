<?php

namespace App\Entity;

use App\Repository\SplapSavingsGoalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SplapSavingsGoalRepository::class)]
class SplapSavingsGoal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $target = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $duedate = null;

    #[ORM\Column]
    private ?int $contributedAmount = null;


    #[ORM\Column]
    private ?string $color = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTarget(): ?int
    {
        return $this->target;
    }

    public function setTarget(int $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function getDuedate(): ?\DateTimeInterface
    {
        return $this->duedate;
    }

    public function setDuedate(\DateTimeInterface $duedate): static
    {
        $this->duedate = $duedate;

        return $this;
    }


    public function getContributedAmount(): ?string
    {
        return $this->contributedAmount;
    }

    public function setContributedAmount(string $contributedAmount): self
    {
        $this->contributedAmount = $contributedAmount;

        return $this;
    }


    public function getMonthlyContribution(): float
    {
        $now = new \DateTime();
        $interval = $now->diff($this->duedate);
        $months = $interval->y * 12 + $interval->m;

        $remainingAmount = $this->target - $this->contributedAmount;

        if ($months == 0) {
            return $remainingAmount;
        }

        return $remainingAmount / $months;
    }
}
