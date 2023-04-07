<?php

namespace App\Tests\Unit\Service\Expense;

use App\Entity\Expense;
use App\Form\Model\Expense\ExpenseModel;
use App\Service\Expense\ExpenseService;
use App\Tests\Unit\Service\Expense\ExpenseFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;

class ExpenseCrudTest extends ExpenseFixtures
{
    protected ExpenseService $expenseService;
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->expenseService = Mockery::mock(ExpenseService::class)->makePartial();
        $this->expenseService->shouldReceive('save')->andReturn($this->expense->getId());
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testSaveExpense(): void
    {
        $expenseId = $this->expense->getId();
        $initialExpenseAmount = $this->expense->getAmount();
        $newExpenseAmount = $initialExpenseAmount++;

        $expenseModel = new ExpenseModel();
        $expenseModel->setId($expenseId)
        ->setAmount($newExpenseAmount);

        $returnedId = $this->expenseService->save($this->expense, $expenseModel);
        $this->assertSame($expenseId, $returnedId, 'Should return $expence->Id');

        $newExpense = $this->entityManager->getRepository(Expense::class)->find($returnedId);
        $this->assertNotNull($newExpense, 'Should found the saved $expense');
        $this->assertInstanceOf(Expense::class, $newExpense, 'Should return the saved $expense');

        $this->assertSame($newExpense->getAmount(), $newExpenseAmount, 'The saved Expence amount incorrectly saved');
    }
}
