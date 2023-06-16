<?php
declare(strict_types=1);

namespace RockujemyWpExt\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class AllowedBlockTypesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AllowedBlockTypes) {
            throw new UnexpectedTypeException($constraint, AllowedBlockTypes::class);
        }

        if (null === $value || is_bool($value)) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $arg) {
            if (!in_array($arg, $this->getBlockTypes())) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $arg)
                    ->addViolation();
            }
        }
    }

    private function getBlockTypes(): array
    {
        return [
            'core/table',
            'core/verse',
            'core/code',
            'core/freeform',
            'core/html',
            'core/preformatted',
            'core/pullquote',
        ];
    }
}
