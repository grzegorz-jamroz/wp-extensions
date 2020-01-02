<?php
declare(strict_types=1);

namespace Grzechu\Validator;

use Symfony\Component\Validator\Constraint;

class Phone extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';
}
