<?php
declare(strict_types=1);

namespace Grzechu\Utilities\Twig\Extension;

class WordpressExtensions
{
    public function language_attributes(string $doctype = 'html'): void
    {
        echo get_language_attributes($doctype);
    }

    public function body_class($class = ''): void
    {
        echo sprintf('class="%s"', join(' ', get_body_class( $class )));
    }

    public function bloginfo(string $show = ''): void
    {
        echo get_bloginfo($show, 'display');
    }

    public function wp_head(): void
    {
        wp_head();
    }

    public function wp_footer(): void
    {
        wp_footer();
    }

    public function wp_title($sep = '&raquo;', $display = true, $seplocation = ''): ?string
    {
        return wp_title($sep, $display, $seplocation);
    }

    public function get_post_meta($post_id, $key = '', $single = false)
    {
        return get_post_meta($post_id, $key, $single);
    }

    public function is_active_sidebar($index)
    {
        return is_active_sidebar($index);
    }

    public function dynamic_sidebar($index = 1)
    {
        dynamic_sidebar($index);
    }

    public function home_url($path = '', $scheme = null) {
        return home_url($path, $scheme);
    }

    public function admin_url($path = '', $scheme = 'admin') {
        return admin_url($path, $scheme);
    }

    function wp_create_nonce($action = -1) {
        return wp_create_nonce($action);
    }
}
