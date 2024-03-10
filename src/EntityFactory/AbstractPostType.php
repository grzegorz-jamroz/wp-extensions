<?php
declare(strict_types=1);

namespace RockujemyWpExt\EntityFactory;

abstract class AbstractPostType implements Entity
{
    protected string $postType;
    protected string $title;
    protected string $content = '';
    protected array $metaInput = [];
    protected string $slug;
    protected array $terms = [];

    public function __construct(
        string $postType,
        string $title
    ) {
        $this->postType = $postType;
        $this->title = $title;
        $this->slug = sanitize_title($this->title);
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setMetaInput(array $meta): self
    {
        $this->metaInput = $meta;

        return $this;
    }

    public function addTerms(array $termIds, string $taxonomy): void
    {
        $this->terms[$taxonomy] = $termIds;
    }

    public function getData(): array
    {
        $now             = current_time( 'mysql' );
        $now_gmt         = current_time( 'mysql', 1 );

        return [
            'post_author'           => get_current_user_id(),
            'post_content'          => $this->content,
            'post_date'             => $now,
            'post_date_gmt'         => $now_gmt,
            'post_status'           => 'publish',
            'post_title'            => $this->title,
            'post_name'             => $this->slug,
            'post_modified'         => $now,
            'post_modified_gmt'     => $now_gmt,
            'post_type'             => $this->postType,
            'meta_input'            => $this->metaInput
        ];
    }

    public function insert(): int
    {
        $result = wp_insert_post($this->getData());

        if ($result instanceof \WP_Error) {
            return 0;
        }

        foreach ($this->terms as $taxonomy => $termIds) {
            wp_set_object_terms($result, $termIds, $taxonomy);
        }

        return $result;
    }
}
