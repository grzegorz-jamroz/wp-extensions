<?php
declare(strict_types=1);

namespace RockujemyWpExt\Utilities\Twig\Extension;

use RockujemyWpExt\Utilities\Asset;

class SymfonyExtensions
{
    public function dump($var) {
        dump($var);
    }

    public function getAssetUrl(string $path, string $entrypointName = 'dist'): string
    {
        if ($entrypointName === ''
            || $entrypointName === '/') {
            return sprintf('%s/%s', get_template_directory_uri(), $path);
        }

        return sprintf('%s/%s/%s', get_template_directory_uri(), $entrypointName, $path);
    }
}
