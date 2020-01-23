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

    abstract public function getSingularName(): string;

    abstract public function getPluralName(): string;

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

    protected function getLabels(): array
    {
        $singular = $this->getSingularName();
        $plural = $this->getPluralName();
        $singularToLower = strtolower($singular);
        $pluralToLower = strtolower($plural);

        return [
            'name' => $plural,
            'singular_name' => $singular,
            'add_new' => 'Add New',
            'add_new_item' => sprintf('Add New %s', $singular),
            'edit_item' => sprintf('Edit %s', $singular),
            'new_item' => sprintf('New %s', $singular),
            'view_item' => sprintf('View %s', $singular),
            'view_items' => sprintf('View %s', $plural),
            'search_items' => sprintf('Search %s', $plural),
            'not_found' => sprintf('No %s found.', $pluralToLower),
            'not_found_in_trash' => sprintf('No %s found in Trash.', $pluralToLower),
            'parent_item_colon' => sprintf('Parent %s:', $singular),
            'all_items' => sprintf('All %s', $plural),
            'archives' => sprintf('%s Archives', $singular),
            'attributes' => sprintf('%s Attributes', $singular),
            'insert_into_item' => sprintf('Insert into %s', $singularToLower),
            'uploaded_to_this_item' => sprintf('Uploaded to this %s', $singularToLower),
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use as featured image',
            'filter_items_list' => sprintf('Filter %s list', $pluralToLower),
            'items_list_navigation' => sprintf('%s list navigation', $plural),
            'items_list' => sprintf('%s list', $plural),
            'item_published' => sprintf('%s published.', $singular),
            'item_published_privately' => sprintf('%s published privately.', $singular),
            'item_reverted_to_draft' => sprintf('%s reverted to draft.', $singular),
            'item_scheduled' => sprintf('%s scheduled.', $singular),
            'item_updated' => sprintf('%s updated.', $singular),
        ];
    }
}

