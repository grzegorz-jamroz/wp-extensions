<?php
declare(strict_types=1);

namespace RockujemyWpExt\FormAction;

abstract class HttpFormAction extends FormAction
{
    public function init(): void
    {
        add_action(sprintf('admin_post_%s', $this->action), [$this, 'submit']);
        add_action(sprintf('admin_post_nopriv_%s', $this->action), [$this, 'submit']);
    }
}
