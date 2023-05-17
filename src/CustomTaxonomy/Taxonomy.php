<?php
declare(strict_types=1);

namespace Grzechu\CustomTaxonomy;

abstract class Taxonomy
{
    private $postTypes;
    private $taxonomyKey;
    private $args = [];
    private static $instances;

    final public static function getInstance(): self
    {
        $className = get_called_class();

        if (isset(self::$instances[$className]) === false) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    abstract public function getTaxonomyKey(): string;

    abstract public function getSingularName(): string;

    abstract public function getPluralName(): string;

    abstract public function getPostTypes(): array;

    abstract public function getArgs(): array;

    protected function getLabels(): array
    {
        $singular = $this->getSingularName();
        $plural = $this->getPluralName();
        $pluralToLower = strtolower($plural);

        return [
            'name' => $plural,
            'singular_name' => $singular,
            'search_items' => sprintf('Search %s', $plural),
            'popular_items' => sprintf('Popular %s', $plural),
            'all_items' => sprintf('All %s', $plural),
            'parent_item' => sprintf('Parent %s', $singular),
            'parent_item_colon' => sprintf('Parent %s:', $singular),
            'edit_item' => sprintf('Edit %s', $singular),
            'view_item' => sprintf('View %s', $singular),
            'update_item' => sprintf('Update %s', $singular),
            'add_new_item' => sprintf('Add New %s', $singular),
            'new_item_name' => sprintf('New %s Name', $singular),
            'separate_items_with_commas' => sprintf('Separate %s with commas', $pluralToLower),
            'add_or_remove_items' => sprintf('Add or remove %s', $pluralToLower),
            'choose_from_most_used' => sprintf('Choose from the most used %s', $pluralToLower),
            'not_found' => sprintf('No %s found', $pluralToLower),
            'no_terms' => sprintf('No %s', $pluralToLower),
            'items_list_navigation' => sprintf('%s list navigation', $plural),
            'items_list' => sprintf('%s list', $plural),
            'most_used' => 'Most Used',
            'back_to_items' => sprintf('&larr; Back to %s', $plural),
        ];
    }

    final private function __construct()
    {
        $this->taxonomyKey = $this->getTaxonomyKey();
        $this->postTypes = $this->getPostTypes();
        $this->args = $this->getArgs();
        (new TaxonomyValidator($this))->validate();

        add_action('init', function () {
            register_taxonomy(
                $this->taxonomyKey,
                $this->postTypes,
                $this->args
            );
        });
    }

    private function __clone()
    {
    }

    final public function __wakeup()
    {
        throw new \Exception("Cannot unserialize");
    }
}
