<?php
declare(strict_types=1);

namespace Grzechu\CustomMetabox\MetaboxField;

use Grzechu\CustomMetabox\MetaboxField;
use WP_Post;

class DropdownField extends MetaboxField
{
    public function html(WP_Post $post): string
    {
        $value = esc_attr(get_post_meta($post->ID, $this->id, true));
        $choices = $this->getChoices($value);

        return <<<HTML
            <p class="post-attributes-label-wrapper">
                <p class="post-attributes-label-wrapper"><strong>$this->label</strong></p>
                <select name="$this->id" id="$this->id">
                    $choices
                </select>
            </p>
        HTML;
    }

    private function getChoices(string $current_value): string
    {
        $choices = $this->getOption('choices');

        $html = '';

        foreach ($choices as $key => $value) {
            $selected = $key === $current_value ? 'selected' : '';

            $html .= <<<HTML
                <option value="$key" $selected>$value</option>
            HTML;
        }

        return $html;
    }
}
