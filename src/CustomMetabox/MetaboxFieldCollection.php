<?php
declare(strict_types=1);

namespace Grzechu\CustomMetabox;

use ArrayIterator;

class MetaboxFieldCollection implements \IteratorAggregate
{
    private $fields = [];

    public function add(MetaboxField ...$fields)
    {
        foreach ($fields as $field) {
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
