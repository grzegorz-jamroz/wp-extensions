<?php
declare(strict_types=1);

namespace RockujemyWpExt\FormAction;

abstract class AjaxFormAction extends FormAction
{
    protected bool $isPublic;

    public function __construct(string $action, bool $isPublic = false)
    {
        $this->isPublic = $isPublic;
        parent::__construct($action);
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action(sprintf('wp_ajax_%s', $this->action), [$this, 'submit']);

        if ($this->isPublic) {
            add_action(sprintf('wp_ajax_nopriv_%s', $this->action), [$this, 'submit']);
        }
    }

    abstract public function enqueueScripts();
}
