<?php
declare(strict_types=1);

namespace Grzechu\CustomTaxonomy;

class Taxonomy
{
    private $postTypes;
    private $taxonomyKey;
    private $options;
    private $args;

    public function __construct(
        string $taxonomyKey,
        array $postTypes,
        TaxonomyOptions $options,
        array $args = []
    ) {
        $this->taxonomyKey = $taxonomyKey;
        $this->postTypes = $postTypes;
        $this->options = $options;
        $this->args = $args;
        (new TaxonomyValidator($this))->validate();

        add_action('init', [$this, 'register']);
    }

    public function register()
    {
        if (!isset($this->args['labels'])) {
            $this->args['labels'] = $this->getDefaultLabels();
        }

        register_taxonomy(
            $this->taxonomyKey,
            $this->postTypes,
            $this->args
        );
    }

    public function getTaxonomyKey(): string
    {
        return $this->taxonomyKey;
    }

    public function getPostTypes(): array
    {
        return $this->postTypes;
    }

    public function getOptions(): TaxonomyOptions
    {
        return $this->options;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    private function getDefaultLabels(): array
    {
        $singular = $this->options->getSingularName();
        $plural = $this->options->getPluralName();
        $pluralLowercase = $this->options->getPluralLowercase();

        return [
            'name'                       => $plural,
            'singular_name'              => $singular,
            'search_items'               => sprintf('Search %s', $plural),
            'popular_items'              => sprintf('Popular %s', $plural),
            'all_items'                  => sprintf('All %s', $plural),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => sprintf('Edit %s', $singular),
            'view_item'                  => sprintf('View %s', $singular),
            'update_item'                => sprintf('Update %s', $singular),
            'add_new_item'               => sprintf('Add New %s', $singular),
            'new_item_name'              => sprintf('New %s Name', $singular),
            'separate_items_with_commas' => sprintf('Separate %s with commas', $pluralLowercase),
            'add_or_remove_items'        => sprintf('Add or remove %s', $pluralLowercase),
            'choose_from_most_used'      => sprintf('Choose from the most used %s', $pluralLowercase),
            'not_found'                  => sprintf('No %s found.', $pluralLowercase),
            'no_terms'                   => sprintf('No %s', $pluralLowercase),
            'items_list_navigation'      => sprintf('%s  list navigation', $plural),
            'items_list'                 => sprintf('%s list', $plural),
            'most_used'                  => 'Most Used',
            'back_to_items'              => sprintf('&larr; Back to  %s', $plural),
        ];
    }
}
