<?php
declare(strict_types=1);

namespace Grzechu\RestApi;

abstract class RestRoute
{
    private static $instances;

    final public static function getInstance(): self
    {
        $className = get_called_class();

        if (isset(self::$instances[$className]) === false) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    public function __toString()
    {
        $url = sprintf('/wp-json/%s%s', $this->getNamespace(), $this->getRoute());

        return home_url($url);
    }

    protected function getNamespace(): string
    {
        return sprintf('%s/v1', wp_get_theme()->template);
    }

    abstract public function __invoke();
    abstract protected function getRoute(): string;
    abstract protected function getArgs(): array;

    final private function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(
                $this->getNamespace(),
                $this->getRoute(),
                $this->getArgs()
            );
        });
    }

    final private function __clone()
    {
    }

    final private function __wakeup()
    {
    }
}
