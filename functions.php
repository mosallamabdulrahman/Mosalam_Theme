<?php
/**
 * Mosalam theme bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MOSALAM_THEME_DIR', get_template_directory());
define('MOSALAM_THEME_URI', get_template_directory_uri());
define('MOSALAM_THEME_VERSION', wp_get_theme()->get('Version'));

require_once MOSALAM_THEME_DIR . '/inc/blocks.php';
require_once MOSALAM_THEME_DIR . '/inc/nav-menus.php';
require_once MOSALAM_THEME_DIR . '/inc/customizer.php';
require_once MOSALAM_THEME_DIR . '/inc/theme-setup.php';
require_once MOSALAM_THEME_DIR . '/inc/security-and-uploads.php';
require_once MOSALAM_THEME_DIR . '/inc/blog.php';
require_once MOSALAM_THEME_DIR . '/inc/projects.php';

/**
 * Theme supports.
 */
function mosalam_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');
    add_editor_style('assets/css/tailwind.css');
}
add_action('after_setup_theme', 'mosalam_setup');

/**
 * Get file modification time as asset version for clean cache-busting.
 */
function mosalam_get_asset_version($relative_path)
{
    $file_path = MOSALAM_THEME_DIR . '/' . ltrim($relative_path, '/');
    if (file_exists($file_path)) {
        return filemtime($file_path);
    }
    return MOSALAM_THEME_VERSION;
}

/**
 * Front-end + editor assets. All compiled from the theme's single node_modules
 * via `npm run build` (see package.json / webpack.config.js).
 */
function mosalam_enqueue_assets()
{
    wp_enqueue_style(
        'mosalam-tailwind',
        MOSALAM_THEME_URI . '/assets/css/tailwind.css',
        [],
        mosalam_get_asset_version('assets/css/tailwind.css')
    );

    $theme_js = MOSALAM_THEME_DIR . '/assets/js/build/theme.js';
    if (file_exists($theme_js)) {
        wp_enqueue_script(
            'mosalam-theme',
            MOSALAM_THEME_URI . '/assets/js/build/theme.js',
            [],
            mosalam_get_asset_version('assets/js/build/theme.js'),
            true
        );
    }

    if (is_page_template('templates/market-analysis-dashboard-template.php')) {
        // Enqueue Chart.js CDN for performance
        wp_enqueue_script(
            'chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js',
            [],
            '4.4.0',
            true
        );

        // Enqueue custom CSS for the dashboard
        wp_enqueue_style(
            'market-analysis-css',
            MOSALAM_THEME_URI . '/assets/css/market-analysis.css',
            [],
            mosalam_get_asset_version('assets/css/market-analysis.css')
        );

        // Enqueue custom JS for the dashboard (depends on chart-js)
        wp_enqueue_script(
            'market-analysis-js',
            MOSALAM_THEME_URI . '/assets/js/market-analysis.js',
            ['chart-js'],
            mosalam_get_asset_version('assets/js/market-analysis.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'mosalam_enqueue_assets');