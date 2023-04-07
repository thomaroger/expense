<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class ExpenseException extends RuntimeException
{
    public const SEARCH_RITERIA_INVALID = 'searchCretiriaInvalid';
    public const FORM_INVALID = 'formInvalid';
    public const NOT_FOUND = 'notFound';
    public const NO_DATA = 'noData';
    public const TYPE_NOT_FOUND = 'typeNotFound';
    public const COMPANY_NOT_FOUND = 'companyNotFound';
    public const UNKNOWN_ERROR = 'unknownError';

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("ExpenseException.$message", $code, $previous);
        /**
         * @todo Use a logger here
         */
    }
}
