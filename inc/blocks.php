<?php
/**
 * Dynamic Gutenberg block registration.
 *
 * Every folder under /blocks/ that contains a block.json is registered
 * automatically as a native block belonging to the "Mosalam_Blocks" category.
 * Add a new block by dropping a new folder in /blocks/ — no code changes here.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the "Mosalam_Blocks" category so all theme blocks are grouped
 * together in the block inserter.
 */
function mosalam_register_block_category($categories)
{
    return array_merge(
        [
            [
                'slug' => 'mosalam-blocks',
                'title' => 'Mosalam_Blocks',
                'icon' => null,
            ],
        ],
        $categories
    );
}
add_filter('block_categories_all', 'mosalam_register_block_category');

/**
 * Scan /blocks/*, registering any folder that has a valid block.json.
 */
function mosalam_register_blocks()
{
    $blocks_dir = MOSALAM_THEME_DIR . '/blocks';

    if (!is_dir($blocks_dir)) {
        return;
    }

    foreach (glob($blocks_dir . '/*', GLOB_ONLYDIR) as $block_dir) {
        if (file_exists($block_dir . '/block.json')) {
            register_block_type($block_dir);
        }
    }
}
add_action('init', 'mosalam_register_blocks');

/**
 * Expose the theme URL to block editor JS (window.mosalamThemeUrl) so block
 * index.js files can build asset URLs for local images (e.g. methodology
 * step photos) without hardcoding an absolute path.
 */
function mosalam_editor_globals()
{
    wp_add_inline_script(
        'wp-blocks',
        'window.mosalamThemeUrl = ' . wp_json_encode(MOSALAM_THEME_URI) . ';',
        'before'
    );
}
add_action('enqueue_block_editor_assets', 'mosalam_editor_globals');
