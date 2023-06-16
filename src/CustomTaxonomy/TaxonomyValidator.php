<?php
declare(strict_types=1);

namespace RockujemyWpExt\CustomTaxonomy;

use RockujemyWpExt\Validator\Slug;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class TaxonomyValidator
{
    private $validator;
    private $taxonomy;
    private $violations;

    public function __construct(Taxonomy $taxonomy)
    {
        $this->validator = Validation::createValidator();
        $this->violations = new ConstraintViolationList();
        $this->taxonomy = $taxonomy;
    }

    /**
     * @throws \Exception
     */
    public function validate(): void
    {
        $this->validateTaxonomyKey();
    }

    private function validateTaxonomyKey()
    {
        $violations = $this->validator->validate(
            $this->taxonomy->getTaxonomyKey(),
            [
                new NotBlank(),
                new Slug(),
                new Length([
                    'max' => 32,
                    'maxMessage' => "TaxonomyKey is too long. It should have {{ limit }} character or less.",
                ])
            ]
        );

        if ($violations->count() > 0) {
            throw new \Exception((string) $violations);
        }
    }
}
