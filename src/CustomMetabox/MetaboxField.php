<?php
declare(strict_types=1);

namespace Grzechu\CustomMetabox;

use WP_Post;

abstract class MetaboxField
{
    protected $id;
    protected $options;

    public function __construct(
        string $id,
        array $options = []
    ) {
        $this->id = $id;
        $this->options = $options;
    }

    abstract public function html(WP_Post $post): string;

    public function getId(): string
    {
        return $this->id;
    }

    public function getOption(string $option)
    {
        return $this->options[$option] ?? null;
    }

    public function save(WP_Post $post)
    {
        if (!array_key_exists($this->id, $_POST)) {
            return;
        }

        $post_type = get_post_type_object($post->post_type);

        if (!current_user_can($post_type->cap->edit_post, $post->ID)) {
            return;
        }

        update_post_meta(
            $post->ID,
            $this->id,
            sanitize_text_field($_POST[$this->id])
        );
    }
}
