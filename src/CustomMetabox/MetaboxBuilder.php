<?php
declare(strict_types=1);

namespace Grzechu\CustomMetabox;

use WP_Post;

abstract class MetaboxBuilder
{
    /**
     * @var MetaboxFieldCollection|MetaboxField[]
     */
    private $fields;

    public function __construct(MetaboxFieldCollection $fields)
    {
        $this->fields = $fields;
        $this->addFields($this->fields);
    }

    public function render(WP_Post $post)
    {
        foreach ($this->fields as $field) {
            echo $field->html($post);
        }
    }

    public function save(WP_Post $post)
    {
        foreach ($this->fields as $field) {
            $field->save($post);
        }
    }

    abstract protected function addFields(MetaboxFieldCollection $fields): void;
}
