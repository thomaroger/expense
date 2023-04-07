<?php

namespace App\Util;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Service\Attribute\Required;

class FormHelper
{
    private FormFactoryInterface $formFactory;

    #[Required]
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    public function createForm(string $formClass, mixed $data = null, array $options = []): FormInterface
    {
        return $this->formFactory->create($formClass, $data, $options);
    }

    public static function submit(FormInterface $form, array $data = [], bool $testValidation = false): ?bool
    {
        $form->submit($data, false);

        if ($testValidation) {
            return $form->isValid();
        }

        return null;
    }

    public static function getErrorsFromViolations(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = [
                'code' => $violation->getCode(),
                'message' => $violation->getMessage(),
                'invalidValue' => $violation->getInvalidValue(),
                'propertyPath' => $violation->getPropertyPath(),
            ];
        }

        return $errors;
    }

    public static function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface && $childErrors = self::getErrorsFromForm($childForm)) {
                $errors = array_merge($childErrors, $errors);
            }
        }

        return $errors;
    }
}
