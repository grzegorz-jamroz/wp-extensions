<?php
declare(strict_types=1);

namespace RockujemyWpExt\Validator\Exception;

class UnexpectedPayloadException extends \RuntimeException
{
    public function __construct($value, string $payloadName, string $expectedType)
    {
        parent::__construct(sprintf('Expected payload "%s" of type "%s", "%s" given', $payloadName, $expectedType, \is_object($value) ? \get_class($value) : \gettype($value)));
    }
}
