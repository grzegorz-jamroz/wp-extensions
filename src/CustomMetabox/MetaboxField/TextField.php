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

        return <<<HTML
            <p class="post-attributes-label-wrapper">
                <p class="post-attributes-label-wrapper"><strong>$this->label</strong></p>
                <input type="text" name="$this->id" id="$this->id" value="$value" />
            </p>
        HTML;
    }
}
