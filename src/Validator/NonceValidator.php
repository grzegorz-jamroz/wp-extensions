<?php
declare(strict_types=1);

namespace Grzechu\Validator;

use Grzechu\Validator\Exception\UnexpectedPayloadException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Exception\ValidatorException;

class NonceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Nonce) {
            throw new UnexpectedTypeException($constraint, Nonce::class);
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $action = $constraint->payload['action'];

        if (!isset($action)) {
            throw new ValidatorException('Missing payload "action".');
        }

        if (!is_string($action)) {
            throw new UnexpectedPayloadException($value, 'action', 'string');
        }

        if (null === $value || wp_verify_nonce($value, $action) === false ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
