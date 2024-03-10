<?php
declare(strict_types=1);

namespace RockujemyWpExt\FormAction;

use RockujemyWpExt\Utilities\SimpleCommandBus\SimpleCommandBus;

abstract class AjaxFormAction extends FormAction
{
    protected bool $isPublic;

    public function __construct(
        string $action,
        SimpleCommandBus $commandBus,
        bool $isPublic = false
    ) {
        parent::__construct($action, $commandBus);
        $this->isPublic = $isPublic;
    }

    public function init(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action(sprintf('wp_ajax_%s', $this->action), [$this, 'submit']);

        if ($this->isPublic) {
            add_action(sprintf('wp_ajax_nopriv_%s', $this->action), [$this, 'submit']);
        }
    }

    abstract public function enqueueScripts(): void;
}
