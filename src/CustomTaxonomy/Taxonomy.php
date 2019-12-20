<?php
declare(strict_types=1);

namespace Grzechu\CustomTaxonomy;

class Taxonomy
{
    private $postTypes;
    private $taxonomyKey;
    private $args;

    public function __construct(
        string $taxonomyKey,
        array $postTypes,
        array $args = []
    ) {
        $this->taxonomyKey = $taxonomyKey;
        $this->postTypes = $postTypes;
        $this->args = $args;
        (new TaxonomyValidator($this))->validate();

        add_action('init', [$this, 'register']);
    }

    public function register() {
        register_taxonomy(
            $this->taxonomyKey,
            $this->postTypes,
            $this->args
        );
    }
}
