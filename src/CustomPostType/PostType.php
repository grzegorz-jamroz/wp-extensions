<?php
declare(strict_types=1);

namespace Grzechu\CustomPostType;

abstract class PostType
{
    protected $postTypeKey;
    protected $args;
    private static $instance;

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    abstract public function getArgs(): array;
    abstract public function getPostTypeKey(): string;

    public function __toString()
    {
        return self::class;
    }

    public function getArg(string $arg)
    {
        return $this->args[$arg] ?? null;
    }

    public function allowed_block_types()
    {
        $post = get_post();
        $allowedBlockTypes = $this->getArg('allowed_block_types');

        if ($allowedBlockTypes === false) {
            return false;
        }

        if ($allowedBlockTypes === null) {
            return true;
        }

        if ($allowedBlockTypes === true) {
            return true;
        }

        if ($post->post_type === $this->postTypeKey) {
            return $allowedBlockTypes;
        }

        return true;
    }

    final private function __construct()
    {
        $this->postTypeKey = $this->getPostTypeKey();
        $this->args = $this->getArgs();

        (new PostTypeValidator($this))->validate();

        add_action('init', function() {
            register_post_type(
                $this->postTypeKey,
                $this->args
            );
        });
        add_filter('allowed_block_types', [$this, 'allowed_block_types']);
    }

    final private function __clone()
    {
    }

    final private function __wakeup()
    {
    }
}
