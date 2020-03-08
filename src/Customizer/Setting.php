<?php
declare(strict_types=1);

namespace Grzechu\Customizer;

abstract class Setting implements SettingInterface
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

    public function __toString()
    {
        return $this->getSettingId();
    }

    public function register(\WP_Customize_Manager $wp_customize): void
    {
        $setting = $wp_customize->get_setting($this->getSettingId());

        if (isset($setting)) {
            throw new \Exception(sprintf('Customizer setting "%s" already exists.', $this->getSettingId()));
        }

        $wp_customize->add_setting(
            $this->getSettingId(),
            $this->getArgs()
        );
    }

    public function getArgs(): array
    {
        return [];
    }

    final private function __clone()
    {
    }

    final private function __wakeup()
    {
    }
}
