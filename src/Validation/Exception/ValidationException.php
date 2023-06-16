<?php

declare(strict_types=1);

namespace Grzechu\Validation\Exception;

use Grzechu\Presenter\Feature\FormErrors;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends \Exception
{
    private ConstraintViolationList $violations;

    public function __construct(
        ConstraintViolationList $violations,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        $this->violations = $violations;
        parent::__construct($message, $code, $previous);
    }

    public function getViolations(): ConstraintViolationList
    {
        return $this->violations;
    }

    public function getFormErrors(): FormErrors
    {
        $assignedErrors = [];
        $notAssignedErrors = [$this->getMessage()];

        foreach ($this->violations as $violation) {
            $field = $violation->getConstraint()->payload['field'] ?? '';

            if ($field === '') {
                $notAssignedErrors[] = $violation->getMessage();
            }

            if ($field !== '') {
                $assignedErrors[$field] = $violation->getMessage();
            }
        }

        return new FormErrors(
            $notAssignedErrors,
            $assignedErrors
        );
    }
}
