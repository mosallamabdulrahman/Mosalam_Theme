<?php
/**
 * On theme activation: create (or update, if already created by this theme)
 * the Home / About Us / Contact Us pages, pre-filled with the Mosalam blocks
 * in the same order as the original design, and set Home as the static
 * front page. Safe to re-run — pages are matched by slug.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Builds a post_content string of self-closing dynamic block comments (no
 * attributes = block.json defaults are used), one per block name.
 */
function mosalam_build_block_content(array $block_names)
{
    $comments = array_map(function ($name) {
        return "<!-- wp:mosalam/{$name} /-->";
    }, $block_names);

    return implode("\n\n", $comments);
}

function mosalam_seed_page($slug, $title, array $block_names)
{
    $existing = get_page_by_path($slug);

    $post_data = [
        'post_title' => $title,
        'post_name' => $slug,
        'post_content' => mosalam_build_block_content($block_names),
        'post_status' => 'publish',
        'post_type' => 'page',
    ];

    if ($existing) {
        $post_data['ID'] = $existing->ID;
        wp_update_post($post_data);
        return $existing->ID;
    }

    return wp_insert_post($post_data);
}

function mosalam_activate_theme()
{
    $home_id = mosalam_seed_page('home', 'Home', [
        'home-side-nav',
        'hero',
        'clients',
        'methodology',
        'ai-foundations',
        'services',
        'sectors',
        'about-preview',
        'tackle-tomorrow',
    ]);

    mosalam_seed_page('about', 'About Us', [
        'about-hero',
        'about-purpose',
        'about-stats',
        'about-difference',
        'about-mission-vision',
        'about-values',
        'about-team',
        'about-global-footprint',
    ]);

    mosalam_seed_page('contact', 'Contact Us', [
        'contact-hero',
        'contact-form',
        'contact-offices',
    ]);

    if ($home_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_id);
    }
}
add_action('after_switch_theme', 'mosalam_activate_theme');
