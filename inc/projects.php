<?php
/**
 * Projects custom post type: registration, taxonomy, classic-editor meta
 * boxes (short description, live URL, image gallery), and small front-end
 * helper functions used by templates/template-projects.php and
 * single-project.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ──────────────────────────────────────────────
 * 1. Register the "project" post type + "project_category" taxonomy.
 *    show_in_rest is left false on both so WordPress falls back to the
 *    classic editor for Projects, per the client's request.
 * ────────────────────────────────────────────── */
function mosalam_register_project_cpt()
{
    register_post_type('project', [
        'labels' => [
            'name' => __('Projects', 'mosalam'),
            'singular_name' => __('Project', 'mosalam'),
            'add_new' => __('Add New', 'mosalam'),
            'add_new_item' => __('Add New Project', 'mosalam'),
            'edit_item' => __('Edit Project', 'mosalam'),
            'new_item' => __('New Project', 'mosalam'),
            'view_item' => __('View Project', 'mosalam'),
            'view_items' => __('View Projects', 'mosalam'),
            'search_items' => __('Search Projects', 'mosalam'),
            'not_found' => __('No projects found', 'mosalam'),
            'not_found_in_trash' => __('No projects found in Trash', 'mosalam'),
            'all_items' => __('All Projects', 'mosalam'),
            'menu_name' => __('Projects', 'mosalam'),
            'name_admin_bar' => __('Project', 'mosalam'),
        ],
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-portfolio',
        'menu_position' => 20,
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'projects', 'with_front' => false],
    ]);
}
add_action('init', 'mosalam_register_project_cpt');

function mosalam_register_project_taxonomy()
{
    register_taxonomy('project_category', 'project', [
        'labels' => [
            'name' => __('Project Categories', 'mosalam'),
            'singular_name' => __('Project Category', 'mosalam'),
            'search_items' => __('Search Project Categories', 'mosalam'),
            'all_items' => __('All Project Categories', 'mosalam'),
            'edit_item' => __('Edit Project Category', 'mosalam'),
            'update_item' => __('Update Project Category', 'mosalam'),
            'add_new_item' => __('Add New Project Category', 'mosalam'),
            'new_item_name' => __('New Project Category Name', 'mosalam'),
            'menu_name' => __('Project Categories', 'mosalam'),
        ],
        'public' => true,
        'show_in_rest' => false,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'project-category', 'with_front' => false],
    ]);
}
add_action('init', 'mosalam_register_project_taxonomy');

/* ──────────────────────────────────────────────
 * 2. Meta boxes (classic PHP meta boxes, no page builder/ACF).
 * ────────────────────────────────────────────── */
function mosalam_add_project_meta_boxes()
{
    add_meta_box(
        'mosalam_project_details',
        __('Project Details', 'mosalam'),
        'mosalam_render_project_details_meta_box',
        'project',
        'normal',
        'high'
    );

    add_meta_box(
        'mosalam_project_gallery',
        __('Project Gallery', 'mosalam'),
        'mosalam_render_project_gallery_meta_box',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mosalam_add_project_meta_boxes');

function mosalam_render_project_details_meta_box($post)
{
    wp_nonce_field('mosalam_save_project_details', 'mosalam_project_details_nonce');

    $short_description = get_post_meta($post->ID, '_mosalam_project_short_description', true);
    $live_url = get_post_meta($post->ID, '_mosalam_project_live_url', true);
    ?>
    <p>
        <label for="mosalam_project_short_description" style="font-weight:600;display:block;margin-bottom:6px;">
            <?php esc_html_e('Short Description', 'mosalam'); ?>
        </label>
        <textarea
            id="mosalam_project_short_description"
            name="mosalam_project_short_description"
            rows="3"
            style="width:100%;"
        ><?php echo esc_textarea($short_description); ?></textarea>
        <span id="mosalam_project_word_count" style="display:block;margin-top:4px;color:#646970;"></span>
        <span class="description">
            <?php esc_html_e('What the site does and how it was built (tech stack). Keep it to ~20 words — it is trimmed automatically on the front end so every project card stays the same height.', 'mosalam'); ?>
        </span>
    </p>
    <p style="margin-top:20px;">
        <label for="mosalam_project_live_url" style="font-weight:600;display:block;margin-bottom:6px;">
            <?php esc_html_e('Live Project URL', 'mosalam'); ?>
        </label>
        <input
            type="url"
            id="mosalam_project_live_url"
            name="mosalam_project_live_url"
            value="<?php echo esc_attr($live_url); ?>"
            placeholder="https://example.com"
            style="width:100%;"
        >
        <span class="description"><?php esc_html_e('Link to the live, deployed site for this project.', 'mosalam'); ?></span>
    </p>
    <p class="description" style="margin-top:16px;">
        <?php esc_html_e('The Project Name comes from the Title field above. The Main Image is set via the Featured Image panel. Use the main editor below for the full write-up shown on the single project page.', 'mosalam'); ?>
    </p>
    <?php
}

function mosalam_render_project_gallery_meta_box($post)
{
    wp_nonce_field('mosalam_save_project_gallery', 'mosalam_project_gallery_nonce');

    $gallery_ids = mosalam_get_project_gallery_ids($post->ID);
    ?>
    <div id="mosalam-project-gallery-field">
        <input type="hidden" id="mosalam_project_gallery_ids" name="mosalam_project_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
        <div id="mosalam-project-gallery-preview" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px;">
            <?php foreach ($gallery_ids as $attachment_id) :
                $thumb = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                if (!$thumb) {
                    continue;
                }
                ?>
                <div class="mosalam-gallery-item" data-id="<?php echo esc_attr($attachment_id); ?>" style="position:relative;width:100px;height:100px;">
                    <img src="<?php echo esc_url($thumb[0]); ?>" style="width:100%;height:100%;object-fit:cover;border:1px solid #dcdcde;border-radius:4px;">
                    <button type="button" class="mosalam-gallery-remove" style="position:absolute;top:-8px;right:-8px;width:22px;height:22px;line-height:20px;border-radius:50%;background:#a00;color:#fff;border:2px solid #fff;cursor:pointer;padding:0;">×</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-secondary" id="mosalam-project-gallery-add">
            <?php esc_html_e('+ Add Images', 'mosalam'); ?>
        </button>
        <p class="description" style="margin-top:8px;">
            <?php esc_html_e('Optional. If you add images here, the single project page shows them as a swipeable gallery.', 'mosalam'); ?>
        </p>
    </div>
    <?php
}

function mosalam_save_project_meta($post_id, $post)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if ('project' !== $post->post_type) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (
        isset($_POST['mosalam_project_details_nonce']) &&
        wp_verify_nonce($_POST['mosalam_project_details_nonce'], 'mosalam_save_project_details')
    ) {
        if (isset($_POST['mosalam_project_short_description'])) {
            update_post_meta(
                $post_id,
                '_mosalam_project_short_description',
                sanitize_textarea_field(wp_unslash($_POST['mosalam_project_short_description']))
            );
        }
        if (isset($_POST['mosalam_project_live_url'])) {
            update_post_meta(
                $post_id,
                '_mosalam_project_live_url',
                esc_url_raw(wp_unslash($_POST['mosalam_project_live_url']))
            );
        }
    }

    if (
        isset($_POST['mosalam_project_gallery_nonce']) &&
        wp_verify_nonce($_POST['mosalam_project_gallery_nonce'], 'mosalam_save_project_gallery')
    ) {
        $ids_raw = isset($_POST['mosalam_project_gallery_ids']) ? wp_unslash($_POST['mosalam_project_gallery_ids']) : '';
        $ids = array_filter(array_map('absint', explode(',', $ids_raw)));
        update_post_meta($post_id, '_mosalam_project_gallery', array_values($ids));
    }
}
add_action('save_post', 'mosalam_save_project_meta', 10, 2);

/* ──────────────────────────────────────────────
 * 3. Admin assets for the meta boxes (word counter + media picker).
 * ────────────────────────────────────────────── */
function mosalam_enqueue_project_admin_assets($hook)
{
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
        return;
    }
    if ('project' !== get_current_screen()->post_type) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script(
        'mosalam-project-admin',
        MOSALAM_THEME_URI . '/assets/js/admin-project-meta.js',
        ['jquery'],
        mosalam_get_asset_version('assets/js/admin-project-meta.js'),
        true
    );
}
add_action('admin_enqueue_scripts', 'mosalam_enqueue_project_admin_assets');

/* ──────────────────────────────────────────────
 * 4. Front-end helpers.
 * ────────────────────────────────────────────── */
function mosalam_get_project_short_description($post_id = null, $word_limit = 20)
{
    $post_id = $post_id ?: get_the_ID();
    $text = get_post_meta($post_id, '_mosalam_project_short_description', true);
    if (!$text) {
        return '';
    }
    return wp_trim_words($text, $word_limit, '…');
}

function mosalam_get_project_live_url($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();
    return get_post_meta($post_id, '_mosalam_project_live_url', true);
}

function mosalam_get_project_gallery_ids($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();
    $ids = get_post_meta($post_id, '_mosalam_project_gallery', true);
    return is_array($ids) ? array_map('absint', $ids) : [];
}

function mosalam_get_project_gallery_urls($post_id = null, $size = 'large')
{
    $urls = [];
    foreach (mosalam_get_project_gallery_ids($post_id) as $attachment_id) {
        $src = wp_get_attachment_image_src($attachment_id, $size);
        if ($src) {
            $urls[] = [
                'url' => $src[0],
                'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
            ];
        }
    }
    return $urls;
}

function mosalam_get_projects_archive_url()
{
    static $url = null;

    if (null !== $url) {
        return $url;
    }

    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'templates/template-projects.php',
        'fields' => 'ids',
    ]);

    $url = $pages ? get_permalink($pages[0]) : home_url('/projects');

    return $url;
}

function mosalam_get_project_category_badge($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();
    $terms = get_the_terms($post_id, 'project_category');
    if (empty($terms) || is_wp_error($terms)) {
        return null;
    }
    return $terms[0];
}
