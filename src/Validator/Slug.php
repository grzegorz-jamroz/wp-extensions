<?php
declare(strict_types=1);

namespace RockujemyWpExt\Validator;

use Symfony\Component\Validator\Constraint;

class Slug extends Constraint
{
    public $message = 'The value "{{ value }}" is not valid. It can contains only lowercase alphanumeric characters, dashes, and underscores.';
}
