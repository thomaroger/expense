<?php

namespace App\Entity;

use App\Entity\Company;
use App\Entity\ExpenseType;
use App\Entity\Traits\GenericValues;
use App\Repository\ExpenseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenseRepository::class)]
class Expense
{
    use GenericValues;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $expenseDate = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpenseType $type = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenseDate(): ?\DateTimeInterface
    {
        return $this->expenseDate;
    }

    public function setExpenseDate(\DateTimeInterface $expenseDate): self
    {
        $this->expenseDate = $expenseDate;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?ExpenseType
    {
        return $this->type;
    }

    public function setType(?ExpenseType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
