<?php
declare(strict_types=1);

namespace Grzechu\FormAction;

abstract class AjaxFormAction extends FormAction
{
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action(sprintf('wp_ajax_%s', $this->action), [$this, 'submit']);
        add_action(sprintf('wp_ajax_nopriv_%s', $this->action), [$this, 'submit']);
    }

    abstract public function enqueueScripts();
}
