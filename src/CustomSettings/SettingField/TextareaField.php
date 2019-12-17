<?php
declare(strict_types=1);

namespace Grzechu\SettingField;

class TextareaField extends SettingField
{
    public function __invoke()
    {
        $value = esc_textarea(get_option($this->id));
        $description = $this->getOption('description');

        echo <<<HTML
            <p>
                <label for="$this->id">$description</label>
            </p>
            <textarea name="$this->id" id="$this->id" class="large-text code" rows="3">$value</textarea>
        HTML;
    }
}
