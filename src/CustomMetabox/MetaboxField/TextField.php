<?php
declare(strict_types=1);

namespace Grzechu\CustomMetabox\MetaboxField;

use Grzechu\CustomMetabox\MetaboxField;
use WP_Post;

class TextField extends MetaboxField
{
    public function html(WP_Post $post): string
    {
        $value = esc_attr(get_post_meta($post->ID, $this->id, true));
        $label = sprintf('<p class="post-attributes-label-wrapper"><strong>%s</strong></p>', $this->getOption('label'));

        return <<<HTML
            <p class="post-attributes-label-wrapper">
                $label
                <input type="text" name="$this->id" id="$this->id" value="$value" />
            </p>
        HTML;
    }
}
