<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings\SettingSection;

use ArrayIterator;
use IteratorAggregate;

class SettingSectionCollection implements IteratorAggregate
{
    private $sections = [];

    public function add(SettingSection ...$sections)
    {
        foreach ($sections as $section) {
            if (!array_key_exists($section->getId(), $this->sections)) {
                $this->sections[$section->getId()] = $section;
            }
        }
    }

    public function hasKey(string $sectionId): bool
    {
        if (array_key_exists($sectionId, $this->sections)) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->sections);
    }
}
