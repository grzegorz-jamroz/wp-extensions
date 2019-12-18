<?php
declare(strict_types=1);

namespace Grzechu\CustomMetabox;

use Grzechu\Validator\Nonce;
use Symfony\Component\Validator\Validation;
use WP_Post;

abstract class Metabox
{
    private $id;
    private $title;
    private $action;
    private $nonce;
    private $screens;
    private $context;
    private $priority;
    private $args;

    /**
     * @var MetaboxBuilder
     */
    private $builder;

    public function __construct(
        string $builderClassName,
        string $id,
        string $title,
        array $screens = [],
        string $context = 'advanced',
        string $priority = 'default',
        array $args = []
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->action = sprintf('%s_update', $id);
        $this->nonce = sprintf('%s_nonce', $id);
        $this->screens = $screens;
        $this->setBuilder($builderClassName);
        $this->setContext($context);
        $this->priority = $priority;
        $this->args = $args;

        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('save_post', [$this, 'save'], 10, 2);
    }

    public function add_meta_box() {
        add_meta_box(
            $this->id,
            $this->title,
            [$this, 'render'],
            $this->screens,
            $this->context,
            $this->priority,
            $this->args
        );
    }

    public function render(WP_Post $post)
    {
        wp_nonce_field(
            sprintf('%s_%s', $this->action, $post->ID),
            $this->nonce
        );

        $this->builder->render($post);
    }

    public function save(int $post_id, WP_Post $post)
    {
        if (!$this->isNonceValid($post_id)) {
            return;
        }

        $this->builder->save($post);
    }


    private function setContext(string $context)
    {
        if (!in_array($context, ['normal', 'side', 'advanced'])) {
            throw new \RuntimeException('Invalid context value. Expected string "normal", "side" or "advanced".');
        }

        $this->context = $context;
    }

    private function setBuilder(string $class): void
    {
        $this->builder = new $class(new MetaboxFieldCollection());
    }

    private function isNonceValid(int $post_id): bool
    {
        $validator = Validation::createValidator();

        $violation = $validator->validate(
            $_POST[$this->nonce] ?? null,
            [new Nonce([
                'payload' => [
                    'action' => sprintf('%s_%s', $this->action, $post_id)
                ]
            ])]
        );

        if (count($violation) > 0) {
            return false;
        }

        return true;
    }
}
