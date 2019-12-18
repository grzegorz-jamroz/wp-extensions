<?php
declare(strict_types=1);

namespace Grzechu\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AllowedBlockTypes extends Constraint
{
    public $message = 'Argument "allowed_block_types" is not valid.';
}
