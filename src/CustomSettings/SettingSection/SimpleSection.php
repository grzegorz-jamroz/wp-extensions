<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings\SettingSection;

class SimpleSection extends SettingSection
{
    public function __invoke()
    {
        $description = $this->getOption('description');
        echo <<<HTML
            <p>$description</p>
        HTML;
    }
}