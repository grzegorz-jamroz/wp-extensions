<?php
declare(strict_types=1);

namespace Grzechu\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class AllowedBlockTypesValidator extends ConstraintValidator
{
    public function validate($values, Constraint $constraint)
    {
        if (!$constraint instanceof AllowedBlockTypes) {
            throw new UnexpectedTypeException($constraint, AllowedBlockTypes::class);
        }

        if (null === $values) {
            return;
        }

        if (!is_array($values)) {
            throw new UnexpectedValueException($values, 'array');
        }

        foreach ($values as $value) {
            if (!in_array($value, $this->getBlockTypes())) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value)
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
