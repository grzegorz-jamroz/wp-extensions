<?php
declare(strict_types=1);

namespace Grzechu\Utilities;

class Asset
{
    private $entryName;
    private $entrypointName;
    private $extension;

    public function __construct(
        string $entryName,
        string $entrypointName,
        string $extension
    ) {
        $this->entryName = $entryName;
        $this->entrypointName = $entrypointName;
        $this->extension = $extension;
    }

    public function getSrc(): string
    {
        $this->entrypointName = sprintf('%s/%s', get_template_directory(), $this->entrypointName);
        $path = sprintf('%s/%s*.%s', $this->entrypointName, $this->entryName, $this->extension);
        $path = glob($path)[0] ?? sprintf('%s/%s.%s', $this->entrypointName, $this->entryName, $this->extension);
        $path = str_replace(get_template_directory(), '', $path);

        return sprintf('%s%s', get_template_directory_uri(), $path);
    }
}
