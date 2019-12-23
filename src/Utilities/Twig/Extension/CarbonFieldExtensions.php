<?php
declare(strict_types=1);

namespace Grzechu\Utilities\Twig\Extension;

use Grzechu\Utilities\Asset;

class CarbonFieldExtensions
{
    public function carbon_get_theme_option($name, $container_id = '')
    {
        return carbon_get_theme_option($name, $container_id);
    }
}
