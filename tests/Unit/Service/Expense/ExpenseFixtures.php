<?php

namespace App\Tests\Unit\Service\Expense;

use App\Entity\Company;
use App\Entity\Expense;
use App\Entity\ExpenseType;
use App\Entity\User;
use App\Tests\Unit\ExpenseTestCase;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;

class ExpenseFixtures extends ExpenseTestCase
{
    protected User $user;
    protected Company $company;
    protected ExpenseType $type;
    protected Expense $expense;
    protected Container $container;
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        // Container
        static::bootKernel();
        $container = static::$kernel->getContainer();
        $this->container = $container;

        // EntityManager
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $this->entityManager = $entityManager;

        // User
        $user = new User();
        $user->setFirstName('Alain')
        ->setLastName('Depont')
        ->setUsername('test' . time() . rand(9,99) . 'username')
        ->setEmail('email' . time() . rand(9,99) . '@test' . rand(9,999) . '.com')
        ->setpassword('Pass' . rand(9,99) . '!' . rand(99,9999))
        ->setBirthDate(new DateTime(rand(1900,2000) . '-' . rand(10,12) . '-' . rand(10,28)))
        ->setCreatedAt(new DateTime('now'))
        ->setUpdatedAt(new DateTime('now'))
        ->setUpdatedBy(1);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->user = $user;

        // Company
        $company = new Company();
        $company->setName('Company TOTO')
        ->setCreatedAt(new DateTime('now'))
        ->setUpdatedAt(new DateTime('now'))
        ->setUpdatedBy($user->getId());
        $this->entityManager->persist($company);
        $this->entityManager->flush();
        $this->company = $company;

        // Type
        $type = new ExpenseType();
        $type->setName('Testing')
        ->setCreatedAt(new DateTime('now'))
        ->setUpdatedAt(new DateTime('now'))
        ->setUpdatedBy($user->getId());
        $this->entityManager->persist($type);
        $this->entityManager->flush();
        $this->type = $type;

        // Expense
        $expense = new Expense();
        $expense->setType($type)
        ->setCompany($company)
        ->setExpenseDate(new DateTime(rand(1900,2000) . '-' . rand(10,12) . '-' . rand(10,28)))
        ->setAmount(rand(1,999)/10)
        ->setCreatedAt(new DateTime('now'))
        ->setUpdatedAt(new DateTime('now'))
        ->setUpdatedBy($user->getId());
        $this->entityManager->persist($expense);
        $this->entityManager->flush();
        $this->expense = $expense;
    }

    public function testExpenseFixtures(): void
    {
        $success = true;
        $this->assertSame($success, true, 'ExpenseFixtures failure.');
    }
}
