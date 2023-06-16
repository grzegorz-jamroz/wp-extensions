<?php
declare(strict_types=1);

namespace Grzechu\FormAction;

use Grzechu\Utilities\SimpleCommandBus\SimpleCommandBus;
use Grzechu\Validation\Exception\ValidationException;

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

    abstract public function init();
    abstract public function submit();

    /**
     * @throws \Exception
     * @throws ValidationException
     */
    protected function handle(object $command): void
    {
        $this->commandBus->handle($command);
    }
}
