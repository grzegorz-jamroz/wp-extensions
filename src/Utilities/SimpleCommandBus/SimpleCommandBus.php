<?php
declare(strict_types=1);

namespace Grzechu\Utilities\SimpleCommandBus;

final class SimpleCommandBus
{
    private $handlers = [];

    public function registerHandler(string $commandClass, $handler): void
    {
        if (!is_object($handler)) {
            throw new \RuntimeException(
                sprintf('Handler has to be "object", "%s" given.', \gettype($handler))
            );
        }

        if (!method_exists($handler, 'handle')) {
            throw new \RuntimeException(
                sprintf('Handler doesn\'t have method "handle"')
            );
        }

        $this->handlers[$commandClass] = $handler;
    }

    public function handle($command): void
    {
        if (!is_object($command)) {
            throw new \RuntimeException(
                sprintf('Command has to be "object", "%s" given.', \gettype($command))
            );
        }

        if (!array_key_exists(get_class($command), $this->handlers)) {
            throw new \RuntimeException(
                sprintf('Command "%s" doesn\'t have registered handler', get_class($command))
            );
        }

        $this->handlers[get_class($command)]->handle($command);
    }
}
