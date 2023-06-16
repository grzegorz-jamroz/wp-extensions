<?php
declare(strict_types=1);

namespace RockujemyWpExt\Utilities\Twig\Extension;

class CarbonFieldExtensions
{
    public function carbon_get_theme_option($name, $container_id = '')
    {
        return carbon_get_theme_option($name, $container_id);
    }

    public function carbon_get_post_meta($id, $name, $container_id = '')
    {
        return carbon_get_post_meta($id, $name, $container_id);
    }
}
