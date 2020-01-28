<?php
declare(strict_types=1);

namespace Grzechu\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class AlphaNumericSpecialValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AlphaNumericSpecial) {
            throw new UnexpectedTypeException($constraint, AlphaNumericSpecial::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        /* @var $constraint AlphaNumericSpecial */
        if (!preg_match('/^[\pL\s0-9-_.,()!?\']+$/u', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
