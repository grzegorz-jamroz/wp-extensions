<?php
declare(strict_types=1);

namespace RockujemyWpExt\Customizer;

abstract class Control
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

    final private function __construct()
    {
        add_action('customize_register', [$this, 'register']);
    }

    public function register(\WP_Customize_Manager $wp_customize): void
    {
        $settingId = (string) $this->getSetting();
        $setting = $wp_customize->get_setting($settingId);

        if (!isset($setting)) {
            throw new \Exception(sprintf('Customizer setting "%s" does not exist.', $settingId));
        }

        $wp_customize->add_control(
            $settingId,
            $this->getArgs()
        );
    }

    abstract public function getSetting(): Setting;

    public function getArgs(): array
    {
        return [];
    }

    private function __clone()
    {
    }

    final public function __wakeup()
    {
        throw new \Exception("Cannot unserialize");
    }
}
