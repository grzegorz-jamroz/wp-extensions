<?php
declare(strict_types=1);

namespace RockujemyWpExt\RestApi;

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

    abstract public function __invoke(\WP_REST_Request $request);
    abstract public function getNamespace(): string;
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

    public function __toString(): string
    {
        return $this->getUrl();
    }

    public function getUrl(): string
    {
        return sprintf('%s/?rest_route=/%s%s', get_site_url() , $this->getNamespace(), $this->getRoute());
    }

    private function __clone()
    {
    }

    final public function __wakeup()
    {
        throw new \Exception("Cannot unserialize");
    }
}
