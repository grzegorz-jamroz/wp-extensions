<?php
declare(strict_types=1);

namespace RockujemyWpExt\Customizer;

abstract class Setting
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

    public function __toString(): string
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

    abstract public function getSettingId(): string;

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
