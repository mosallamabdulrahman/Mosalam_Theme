<?php
/**
 * Navigation menu locations for the header mega menu and the two footer
 * link columns.
 */

if (!defined('ABSPATH')) {
    exit;
}

function mosalam_register_nav_menus()
{
    register_nav_menus([
        'primary_menu' => __('Primary Menu', 'mosalam'),
        'mega_menu' => __('Mega Menu (Services)', 'mosalam'),
        'footer_explore' => __('Footer: Explore', 'mosalam'),
        'footer_compliance' => __('Footer: Compliance', 'mosalam'),
    ]);
}
add_action('after_setup_theme', 'mosalam_register_nav_menus');

/**
 * Builds the mega menu columns from the "mega_menu" WP menu location.
 */
function mosalam_get_mega_menu_columns()
{
    if (!has_nav_menu('mega_menu')) {
        return [];
    }

    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations['mega_menu']);
    if (!$menu) {
        return [];
    }

    $items = wp_get_nav_menu_items($menu->term_id);
    if (empty($items)) {
        return [];
    }

    $columns = [];
    $column_by_id = [];

    foreach ($items as $item) {
        if ((int) $item->menu_item_parent === 0) {
            $columns[$item->ID] = [
                'title' => $item->title,
                'links' => [],
            ];
            $column_by_id[$item->ID] = $item->ID;
        }
    }

    foreach ($items as $item) {
        $parent_id = (int) $item->menu_item_parent;
        if ($parent_id !== 0 && isset($columns[$parent_id])) {
            $columns[$parent_id]['links'][] = [
                'name' => $item->title,
                'url' => $item->url,
            ];
        }
    }

    return array_slice(array_values($columns), 0, 2);
}

/**
 * Add custom classes to nav menu link attributes.
 * Highly optimized for Tailwind and SEO/semantic structure.
 */
function mosalam_add_menu_link_class( $atts, $item, $args ) {
    if ( isset( $args->theme_location ) ) {
        if ( 'primary_menu' === $args->theme_location ) {
            if ( isset( $args->menu_class ) && strpos( $args->menu_class, 'lg:flex' ) !== false ) {
                // Desktop Primary Menu links
                $atts['class'] = 'text-white/80 hover:text-white transition-all';
            } else {
                // Mobile Primary Menu links
                $atts['class'] = 'text-h3 text-white hover:text-secondary transition-colors';
            }
        } elseif ( in_array( $args->theme_location, [ 'footer_explore', 'footer_compliance' ], true ) ) {
            // Footer Menu links
            $atts['class'] = 'text-[#001b35]/60 hover:text-secondary hover:translate-x-2 transition-all duration-300 block text-[15px] font-body';
        }
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'mosalam_add_menu_link_class', 10, 3 );
