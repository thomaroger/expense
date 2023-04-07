<?php

namespace App\Controller\Expense;

use App\Entity\Expense;
use App\Exception\ExpenseException;
use App\Form\Model\Expense\ExpenseModel;
use App\Form\Type\Expense\ExpenseFormType;
use App\Service\Expense\ExpenseService;
use App\Util\FormHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/expenses')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly ExpenseService $expenseService,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/expense/{id}', name: 'app_expenses_expense_edit', methods: [Request::METHOD_PUT])]
    //#[IsGranted('ROLE_ADMIN')]
    public function editExpense(
        Request $request,
        ?Expense $expense
    ): JsonResponse
    {
        if(null === $expense) {
            return $this->json([
                'result' => false,
                'errors' => ['ExpenseException.' . ExpenseException::NOT_FOUND => []],
            ]);
        }

        $requestData = $request->toArray();
        if(!count($requestData)) {
            return $this->json([
                'result' => false,
                'errors' => ['ExpenseException.' . ExpenseException::NO_DATA => []],
            ]);
        }

        $requestExpenseModel = new ExpenseModel();
        $form = $this->createForm(ExpenseFormType::class, $requestExpenseModel);
        if (!FormHelper::submit($form, $requestData, true)) {
            $errors = FormHelper::getErrorsFromForm($form);
            if (count($errors) > 0) {
                return $this->json([
                    'result' => false,
                    'errors' => ['ExpenseException.' . ExpenseException::FORM_INVALID => [$errors]],
                ]);
            }
        }

        try {
            $this->expenseService->edit($expense, $requestExpenseModel);
        } catch (ExpenseException $e) {
            return $this->json([
                'result' => false,
                'errors' => ['ExpenseException.' . ExpenseException::FORM_INVALID => [$e->getMessage()]],
            ]);
        }

        return $this->json([
            'result' => true,
        ]);
    }
}
