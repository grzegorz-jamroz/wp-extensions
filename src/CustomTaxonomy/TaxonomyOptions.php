<?php
declare(strict_types=1);

namespace Grzechu\CustomTaxonomy;

class TaxonomyOptions
{
    private $singularName;
    private $pluralName;
    private $pluralNameLowercase;

    public function __construct(
        string $singularName,
        string $pluralName
    ) {
        $this->singularName = $singularName;
        $this->pluralName = $pluralName;
        $this->pluralNameLowercase = strtolower($pluralName);
    }

    public function getSingularName(): string
    {
        return $this->singularName;
    }

    public function getPluralName(): string
    {
        return $this->pluralName;
    }

    public function getPluralLowercase(): string
    {
        return $this->pluralNameLowercase;
    }
}
