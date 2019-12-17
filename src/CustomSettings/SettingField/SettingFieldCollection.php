<?php
declare(strict_types=1);

namespace Grzechu\SettingField;

use Grzechu\SettingSection\SettingSectionCollection;
use ArrayIterator;
use IteratorAggregate;

class SettingFieldCollection implements IteratorAggregate
{
    private $fields = [];

    /**
     * @var SettingSectionCollection
     */
    private $sections;

    public function __construct(SettingSectionCollection $sections)
    {
        $this->sections = $sections;
    }

    public function add(SettingField ...$fields)
    {
        foreach ($fields as $field) {
            if (!$this->sections->hasKey($field->getSection())) {
                throw new \RuntimeException(
                    sprintf('Given section "%s" is not registered.', $field->getSection())
                );
            }

            if (!array_key_exists($field->getId(), $this->fields)) {
                $this->fields[$field->getId()] = $field;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->fields);
    }
}
