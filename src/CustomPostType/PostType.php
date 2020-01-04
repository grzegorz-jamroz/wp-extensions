<?php
declare(strict_types=1);

namespace Grzechu\CustomPostType;

abstract class PostType
{
    private $postTypeKey;
    private $args;

    public function __construct(
        string $postTypeKey,
        array $args = []
    ) {
        $this->postTypeKey = $postTypeKey;
        $this->args = $args;
        (new PostTypeValidator($this))->validate();

        add_action('init', [$this, 'register']);
        add_filter('allowed_block_types', [$this, 'allowed_block_types']);
    }

    public function register() {
        register_post_type(
            $this->postTypeKey,
            $this->args
        );
    }

    public function __toString()
    {
        return self::class;
    }

    public function getPostTypeKey(): string
    {
        return $this->postTypeKey;
    }

    public function getArg(string $arg)
    {
        return $this->args[$arg] ?? null;
    }

    public function allowed_block_types()
    {
        $post = get_post();
        $allowedBlockTypes = $this->args['allowed_block_types'] ?? null;

        if ($allowedBlockTypes === false) {
            return false;
        }

        if ($allowedBlockTypes === null || $allowedBlockTypes === true) {
            return true;
        }

        if ($post->post_type === $this->postTypeKey) {
            return $allowedBlockTypes;
        }
    }
}
