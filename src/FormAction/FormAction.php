<?php
declare(strict_types=1);

namespace RockujemyWpExt\FormAction;

use RockujemyWpExt\Utilities\SimpleCommandBus\SimpleCommandBus;
use RockujemyWpExt\Validation\Exception\ValidationException;

abstract class FormAction
{
    protected string $action;
    private SimpleCommandBus $commandBus;

    public function __construct(
        string $action,
        SimpleCommandBus $commandBus
    ) {
        $this->action = $action;
        $this->commandBus = $commandBus;
        $this->init();
    }

    abstract public function init(): void;
    abstract public function submit(): void;

    /**
     * @throws \Exception
     * @throws ValidationException
     */
    protected function handle(object $command): void
    {
        $this->commandBus->handle($command);
    }
}
