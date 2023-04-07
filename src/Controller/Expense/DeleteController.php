<?php

namespace App\Controller\Expense;

use App\Entity\Expense;
use App\Exception\ExpenseException;
use App\Service\Expense\ExpenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/expenses')]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly ExpenseService $expenseService
    ) {
    }
    #[Route(path: '/expense/{id}', name: 'app_expenses_expense_delete', methods: [Request::METHOD_DELETE])]
    //#[IsGranted('ROLE_ADMIN')]
    public function deleteExpense(
        ?Expense $expense
    ): JsonResponse
    {
        if(null === $expense) {
            return $this->json([
                'result' => false,
                'errors' => ['ExpenseException.' . ExpenseException::NOT_FOUND => []],
            ]);
        }

        if(!$this->expenseService->delete($expense)) {
            return $this->json([
                'result' => false,
                'errors' => ['ExpenseException.' . ExpenseException::UNKNOWN_ERROR => []],
            ]);
        }

        return $this->json([
            'result' => true,
        ]);
    }
}
