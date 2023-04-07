<?php

namespace App\Service\Expense;

use App\Entity\Expense;
use App\Exception\ExpenseException;
use App\Form\Model\Expense\ExpenseModel;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ExpenseService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function formatExpenceDetails(Expense $expense): array
    {
        return [
            'id' => $expense->getId(),
            'type' => $expense->getType()->getName(),
            'company' => $expense->getCompany()->getName(),
            'amount' => $expense->getAmount(),
            'expense_date' => $expense->getExpenseDate()->format('Y-m-d'),
            'created_at' => $expense->getCreatedAt()->format('Y-m-d H:i:s'),
            'modifiyed_at' => $expense->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public function search(array $criteria = []): array
    {
        $result = [];

        $criteria['deletedAt'] = null;

        $expenses = (count($criteria))
            ? $this->entityManager->getRepository(Expense::class)->findBy($criteria)
            : $this->entityManager->getRepository(Expense::class)->findAll()
        ;

        foreach ($expenses as $expense) {
            $result[] = $this->formatExpenceDetails($expense);
        }

        return $result;
    }

    /**
     * @throws ExpenseException
     */
    public function save(Expense $expense, ExpenseModel $expenseModel): ?int
    {
        $type = $this->entityManager->getRepository(ExpenseType::class)->find($expenseModel->getTypeId());
        if(null === $type || $type->getDeletedAt() !== null) {
            throw new ExpenseException(ExpenseException::TYPE_NOT_FOUND);
        }
        $company = $this->entityManager->getRepository(Company::class)->find($expenseModel->getCompanyId());
        if(null === $company || $type->getDeletedAt() !== null) {
            throw new ExpenseException(ExpenseException::COMPANY_NOT_FOUND);
        }

        $expense->setAmount((float)$expenseModel->getAmount())
            ->setType($type)
            ->setCompany($company)
            ->setExpenseDate($expenseModel->getExpenseDate())
            ->setCreatedAt(new DateTime('now'))
            ->setUpdatedAt(new DateTime('now'))
            ->setUpdatedBy(1) /** @todo Set appropriated value */
        ;
        $this->entityManager->persist($expense);
        $this->entityManager->flush();

        return $expense->getId();
    }

    /**
     * @throws ExpenseException
     */
    public function create(ExpenseModel $expenseModel): ?int
    {
        $type = $this->entityManager->getRepository(ExpenseType::class)->find($expenseModel->getTypeId());
        if(null === $type || $type->getDeletedAt() !== null) {
            throw new ExpenseException(ExpenseException::TYPE_NOT_FOUND);
        }
        $company = $this->entityManager->getRepository(Company::class)->find($expenseModel->getCompanyId());
        if(null === $company || $type->getDeletedAt() !== null) {
            throw new ExpenseException(ExpenseException::COMPANY_NOT_FOUND);
        }

        $expense = new Expense();
        return $this->save($expense, $expenseModel);
    }

    /**
     * @throws ExpenseException
     */
    public function edit(Expense $expense, ExpenseModel $expenseModel): ?int
    {
        // Extra business rules validation here..

        return $this->save($expense, $expenseModel);
    }

    /**
     * @throws ExpenseException
     */
    public function delete(Expense $expense): bool
    {
        // Extra business rules validation here..

        // Can use logical deletation instead ?!

        $expense->setDeletedAt(new DateTime('now'));
        $this->entityManager->persist($expense);
        $this->entityManager->remove($expense); /** @todo Remove if logical deletation only */
        $this->entityManager->flush();

        return true;
    }
}
