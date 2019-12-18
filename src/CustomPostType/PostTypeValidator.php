<?php
declare(strict_types=1);

namespace Grzechu\CustomPostType;

use Grzechu\Validator\AllowedBlockTypes;
use Grzechu\Validator\Slug;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class PostTypeValidator
{
    private $validator;
    private $postType;
    private $violations;

    public function __construct(PostType $postType)
    {
        $this->validator = Validation::createValidator();
        $this->violations = new ConstraintViolationList();
        $this->postType = $postType;
    }

    /**
     * @throws \Exception
     */
    public function validate(): void
    {
        $this->validatePostTypeKey();
        $this->validateAllowedBlockTypes();
    }

    private function validatePostTypeKey()
    {
        $violations = $this->validator->validate(
            $this->postType->getPostTypeKey(),
            [
                new NotBlank(),
                new Slug(),
                new Length([
                    'max' => 20,
                    'maxMessage' => "PostTypeKey is too long. It should have {{ limit }} character or less.",
                ])
            ]
        );

        if ($violations->count() > 0) {
            throw new \Exception((string) $violations);
        }
    }

    private function validateAllowedBlockTypes()
    {
        $violations = $this->validator->validate(
            $this->postType->getArg('allowed_block_types'),
            [
                new AllowedBlockTypes(),
            ]
        );

        if ($violations->count() > 0) {
            throw new \Exception((string) $violations);
        }
    }
}
