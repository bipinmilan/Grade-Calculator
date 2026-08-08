<?php
class Scorebook_Walker_Nav_Menu extends Walker_Nav_Menu {

    // Start each <li>
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes) || $this->has_children_check($item, $args);

        $li_classes = $classes;
        if ($has_children) {
            $li_classes[] = 'has-submenu';
        }
        $class_names = implode(' ', array_filter($li_classes));

        $output .= "{$indent}<li class=\"{$class_names}\">";

        $atts = [];
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts['class'] = 'nav-link' . (in_array('nav-cta', $classes) ? ' nav-cta' : '');

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . $title . ($args->link_after ?? '');
        $item_output .= '</a>';

        // Add a submenu toggle button right after the link, for accessible mobile tapping
        if ($has_children) {
            $item_output .= '<button class="submenu-toggle" aria-expanded="false" aria-label="Toggle submenu"><i class="fa-solid fa-chevron-down"></i></button>';
        }

        $item_output .= $args->after ?? '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // Wrap submenus
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}<ul class=\"submenu\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}</ul>\n";
    }

    // Helper — WP core sets this class itself when children exist, but keep a fallback
    private function has_children_check($item, $args) {
        return false;
    }
}