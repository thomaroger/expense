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
class DetailController extends AbstractController
{
    public function __construct(
        private readonly ExpenseService $expenseService
    ) {
    }

    #[Route(path: '/expense/{id}', name: 'app_expenses_expense_detail', methods: [Request::METHOD_GET])]
    //#[IsGranted('ROLE_USER')]
    public function detailExpense(
        ?Expense $expense
    ): JsonResponse
    {
        if(null === $expense) {
            return $this->json([
                'result' => false,
                'errors' => ['ExpenseException.' . ExpenseException::NOT_FOUND => []],
            ]);
        }

        return $this->json([
            'result' => true,
            'data' => ['expense' => $this->expenseService->formatExpenceDetails($expense)],
        ]);
    }
}
