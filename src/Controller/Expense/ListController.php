<?php

namespace App\Controller\Expense;

use App\Service\Expense\ExpenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/expenses')]
class ListController extends AbstractController
{
    public function __construct(
        private readonly ExpenseService $expenseService
    ) {
    }

    #[Route(path: '/all', name: 'app_expenses_list_all', methods: [Request::METHOD_GET])]
    //#[IsGranted('ROLE_USER')]
    public function listAllExpenses(): JsonResponse
    {

        return $this->json([
            'result' => true,
            'data' => ['expenses' => $this->expenseService->search()],
        ]);
    }

    #[Route(path: '/search', name: 'app_expenses_search', methods: [Request::METHOD_GET])]
    //#[IsGranted('ROLE_USER')]
    public function searchExpense(Request $request): JsonResponse
    {
        /**
         * @todo create searchModel and searchType to validate params
         * throw \App\Exception\ExpenseException::SEARCH_RITERIA_INVALID when search criteria are not valid
         * @see CreationController for exemple
         */

        $expenses = $this->expenseService->search($request->query->all());

        return $this->json([
            'result' => true,
            'data' => ['expenses' => $expenses],
        ]);
    }
}
