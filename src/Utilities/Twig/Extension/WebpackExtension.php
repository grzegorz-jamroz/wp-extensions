<?php
declare(strict_types=1);

namespace Grzechu\Utilities\Twig\Extension;

use Grzechu\Utilities\Asset;

class WebpackExtension
{
    public function webpackEntryScriptTag(string $entryName, string $entrypointName = 'dist')
    {
        $path = new Asset($entryName, $entrypointName, 'js');

        echo sprintf('<script src="%s"></script>', $path->getSrc());
    }

    public function webpackEntryCssTag(string $entryName, string $entrypointName = 'dist')
    {
        $path = new Asset($entryName, $entrypointName, 'css');

        echo sprintf('<link rel="stylesheet" href="%s">', $path->getSrc());
    }
}
