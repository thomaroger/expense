<?php

namespace App\Form\Model\Expense;

use DateTime;

class ExpenseModel
{
    private ?string $id = null;
    private ?int $typeId = null;
    private ?int $companyId = null;
    private ?float $amount = null;
    private ?DateTime $expenseDate = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $typeId): self
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    public function setCompanyId(?int $companyId): self
    {
        $this->companyId = $companyId;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExpenseDate(): ?DateTime
    {
        return $this->expenseDate;
    }

    public function setExpenseDate(?DateTime $expenseDate): self
    {
        $this->expenseDate = $expenseDate;

        return $this;
    }
}
