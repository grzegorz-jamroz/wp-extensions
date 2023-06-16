<?php
declare(strict_types=1);

namespace RockujemyWpExt\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Nonce extends Constraint
{
    public $message = 'The value "{{ value }}" is not valid.';
}
