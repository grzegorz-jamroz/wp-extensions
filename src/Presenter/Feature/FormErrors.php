<?php
declare(strict_types=1);

namespace RockujemyWpExt\Presenter\Feature;

use Ifrost\Foundations\ArrayConstructable;
use PlainDataTransformer\Transform;

class FormErrors implements ArrayConstructable, \JsonSerializable
{
    private array $notAssigned;
    private array $assigned;

    public function __construct(
        array $notAssigned = [],
        array $assigned = []
    ) {
        $this->notAssigned = $notAssigned;
        $this->assigned = $assigned;
    }

    public function getAssigned(): array
    {
        return $this->assigned;
    }

    public function getNotAssigned(): array
    {
        return $this->notAssigned;
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            Transform::toArray($data['notAssigned'] ?? []),
            Transform::toArray($data['assigned'] ?? []),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'notAssigned' => $this->notAssigned,
            'assigned' => $this->assigned,
        ];
    }
}
