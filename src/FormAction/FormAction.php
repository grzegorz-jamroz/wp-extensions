<?php
declare(strict_types=1);

namespace Grzechu\FormAction;

use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class FormAction
{
    protected $action;

    public function __construct(string $action)
    {
        $this->action = $action;
        $this->init();
    }

    abstract public function init();
    abstract public function submit();

    public function getErrorMessages(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = $violation->getMessage();
        }

        return $errors;
    }
}
