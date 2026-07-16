<?php
/**
 * 1. تسجيل تصنيف (Category) خاص ببلوكات Derwaza في محرر الووردبريس (Gutenberg)
 */
function derwaza_register_block_category($categories) {
    return array_merge(
        [
            [
                'slug'  => 'derwazamall',
                'title' => 'Derwaza Mall',
                'icon'  => null,
            ]
        ],
        $categories
    );
}
add_filter('block_categories_all', 'derwaza_register_block_category');

/**
 * 2. تسجيل البلوكات ديناميكياً من خلال قراءة ملفات block.json تلقائياً
 */
function derwaza_register_blocks() {
    // تحديد مسار مجلد البلوكات في القالب الجديد
    $blocks_dir = get_stylesheet_directory() . '/blocks';

    if (!is_dir($blocks_dir)) {
        return;
    }

    // البحث عن أي مجلد يحتوي على block.json وتسجيله تلقائياً
    foreach (glob($blocks_dir . '/*', GLOB_ONLYDIR) as $block_dir) {
        if (file_exists($block_dir . '/block.json')) {
            register_block_type($block_dir);
        }
    }
}
add_action('init', 'derwaza_register_blocks');

/**
 * 3. تعريف رابط القالب للـ JavaScript (حتى تعمل الصور والملفات الافتراضية للبلوكات في لوحة التحكم)
 */
function derwaza_editor_globals() {
    wp_add_inline_script(
        'wp-blocks',
        'window.mosalamThemeUrl = ' . wp_json_encode(get_stylesheet_directory_uri()) . ';',
        'before'
    );
}
add_action('enqueue_block_editor_assets', 'derwaza_editor_globals');
