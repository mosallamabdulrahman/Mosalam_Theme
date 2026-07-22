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
        'supports' => ['title'],
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
}
add_action('add_meta_boxes', 'mosalam_add_project_meta_boxes');

function mosalam_render_project_details_meta_box($post)
{
    wp_nonce_field('mosalam_save_project_details', 'mosalam_project_details_nonce');

    $short_description = get_post_meta($post->ID, '_mosalam_project_short_description', true);
    $live_url = get_post_meta($post->ID, '_mosalam_project_live_url', true);
    
    // Fetch custom logo from standard featured image ID
    $logo_id = get_post_meta($post->ID, '_thumbnail_id', true);
    $logo_url = '';
    if ($logo_id) {
        $logo_src = wp_get_attachment_image_src($logo_id, 'thumbnail');
        if ($logo_src) {
            $logo_url = $logo_src[0];
        }
    }
    ?>
    <style>
        .mosalam-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            align-items: flex-start;
            margin: 10px 0;
        }
        .mosalam-meta-col-inputs {
            flex: 1 1 400px;
            min-width: 280px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .mosalam-meta-col-logo {
            flex: 0 0 250px;
            min-width: 220px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-left: 1px solid #dcdcde;
            padding-left: 30px;
        }
        /* Handle RTL layout dynamically for Arabic admin panels */
        .rtl .mosalam-meta-col-logo {
            border-left: none;
            padding-left: 0;
            border-right: 1px solid #dcdcde;
            padding-right: 30px;
        }
        @media (max-width: 782px) {
            .mosalam-meta-col-logo {
                border-left: none;
                padding-left: 0;
                border-top: 1px solid #dcdcde;
                padding-top: 20px;
                flex: 1 1 100%;
            }
            .rtl .mosalam-meta-col-logo {
                border-right: none;
                padding-right: 0;
                border-top: 1px solid #dcdcde;
                padding-top: 20px;
                flex: 1 1 100%;
            }
        }
    </style>

    <div class="mosalam-meta-row">
        <!-- Inputs Column -->
        <div class="mosalam-meta-col-inputs">
            <div>
                <label for="mosalam_project_short_description" style="font-weight:600;display:block;margin-bottom:6px;font-size:13px;">
                    <?php esc_html_e('Short Description', 'mosalam'); ?>
                </label>
                <textarea
                    id="mosalam_project_short_description"
                    name="mosalam_project_short_description"
                    rows="3"
                    style="width:100%;"
                ><?php echo esc_textarea($short_description); ?></textarea>
                <span id="mosalam_project_word_count" style="display:block;margin-top:4px;color:#646970;font-size:12px;"></span>
                <span class="description" style="display:block;margin-top:4px;line-height:1.4;">
                    <?php esc_html_e('What the site does and how it was built (tech stack). Keep it to ~20 words.', 'mosalam'); ?>
                </span>
            </div>
            
            <div>
                <label for="mosalam_project_live_url" style="font-weight:600;display:block;margin-bottom:6px;font-size:13px;">
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
                <span class="description" style="display:block;margin-top:4px;"><?php esc_html_e('Link to the live, deployed site for this project.', 'mosalam'); ?></span>
            </div>
        </div>

        <!-- Logo Uploader Column -->
        <div class="mosalam-meta-col-logo">
            <label style="font-weight:600;display:block;font-size:13px;">
                <?php esc_html_e('Project Logo', 'mosalam'); ?>
            </label>
            <div id="mosalam-logo-uploader">
                <input type="hidden" id="mosalam_project_logo_id" name="mosalam_project_logo_id" value="<?php echo esc_attr($logo_id); ?>">
                <div id="mosalam-logo-preview" style="margin-bottom:12px; <?php echo empty($logo_url) ? 'display:none;' : ''; ?>">
                    <img src="<?php echo esc_url($logo_url); ?>" style="max-width:100%; max-height:100px; object-contain; border:1px solid #dcdcde; border-radius:4px; padding:4px; background:#fff; display:block;">
                </div>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <button type="button" class="button" id="mosalam-logo-upload-btn">
                        <?php esc_html_e('Choose Logo Image', 'mosalam'); ?>
                    </button>
                    <button type="button" class="button button-link-delete" id="mosalam-logo-remove-btn" style="<?php echo empty($logo_url) ? 'display:none;' : ''; ?>">
                        <?php esc_html_e('Remove', 'mosalam'); ?>
                    </button>
                </div>
            </div>
            <span class="description" style="display:block;margin-top:4px;line-height:1.4;"><?php esc_html_e('Upload or choose a logo image file (PNG/SVG) for the portfolio grid.', 'mosalam'); ?></span>
        </div>
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
        if (isset($_POST['mosalam_project_logo_id'])) {
            $logo_id = absint($_POST['mosalam_project_logo_id']);
            if ($logo_id) {
                update_post_meta($post_id, '_thumbnail_id', $logo_id);
            } else {
                delete_post_meta($post_id, '_thumbnail_id');
            }
        }
    }
}
add_action('save_post', 'mosalam_save_project_meta', 10, 2);

/* ──────────────────────────────────────────────
 * 3. Category Custom Term Meta (Title & Hero Background Image)
 * ────────────────────────────────────────────── */
function mosalam_add_project_category_fields()
{
    wp_nonce_field('mosalam_save_category_meta', 'mosalam_category_meta_nonce');
    ?>
    <div class="form-field">
        <label for="mosalam_category_title"><?php esc_html_e('Custom Display Title', 'mosalam'); ?></label>
        <input type="text" name="mosalam_category_title" id="mosalam_category_title" value="">
        <p><?php esc_html_e('Custom title displayed above the projects grid when this category tab is active.', 'mosalam'); ?></p>
    </div>
    <div class="form-field">
        <label><?php esc_html_e('Hero Background Image', 'mosalam'); ?></label>
        <input type="hidden" name="mosalam_category_hero_bg_id" id="mosalam_category_hero_bg_id" value="">
        <div id="mosalam-cat-bg-preview" style="margin-bottom:10px; display:none;">
            <img src="" style="max-width:200px; height:auto; border:1px solid #dcdcde; border-radius:4px; padding:4px; background:#fff; display:block;">
        </div>
        <button type="button" class="button" id="mosalam-cat-bg-upload-btn"><?php esc_html_e('Choose Hero Background', 'mosalam'); ?></button>
        <button type="button" class="button button-link-delete" id="mosalam-cat-bg-remove-btn" style="display:none; margin-left:8px;"><?php esc_html_e('Remove', 'mosalam'); ?></button>
        <p><?php esc_html_e('Upload a custom hero background image for this category tab.', 'mosalam'); ?></p>
    </div>
    <?php
}
add_action('project_category_add_form_fields', 'mosalam_add_project_category_fields');

function mosalam_edit_project_category_fields($term)
{
    wp_nonce_field('mosalam_save_category_meta', 'mosalam_category_meta_nonce');
    $title = get_term_meta($term->term_id, '_mosalam_category_title', true);
    $bg_id = get_term_meta($term->term_id, '_mosalam_category_hero_bg_id', true);
    $bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';
    ?>
    <tr class="form-field">
        <th scope="row"><label for="mosalam_category_title"><?php esc_html_e('Custom Display Title', 'mosalam'); ?></label></th>
        <td>
            <input type="text" name="mosalam_category_title" id="mosalam_category_title" value="<?php echo esc_attr($title); ?>">
            <p class="description"><?php esc_html_e('Custom title displayed above the projects grid when this category tab is active.', 'mosalam'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label><?php esc_html_e('Hero Background Image', 'mosalam'); ?></label></th>
        <td>
            <input type="hidden" name="mosalam_category_hero_bg_id" id="mosalam_category_hero_bg_id" value="<?php echo esc_attr($bg_id); ?>">
            <div id="mosalam-cat-bg-preview" style="margin-bottom:10px; <?php echo empty($bg_url) ? 'display:none;' : ''; ?>">
                <img src="<?php echo esc_url($bg_url); ?>" style="max-width:200px; height:auto; border:1px solid #dcdcde; border-radius:4px; padding:4px; background:#fff; display:block;">
            </div>
            <button type="button" class="button" id="mosalam-cat-bg-upload-btn"><?php esc_html_e('Choose Hero Background', 'mosalam'); ?></button>
            <button type="button" class="button button-link-delete" id="mosalam-cat-bg-remove-btn" style="<?php echo empty($bg_url) ? 'display:none;' : ''; ?> margin-left:8px;"><?php esc_html_e('Remove', 'mosalam'); ?></button>
            <p class="description"><?php esc_html_e('Upload a custom hero background image for this category tab.', 'mosalam'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('project_category_edit_form_fields', 'mosalam_edit_project_category_fields');

function mosalam_save_project_category_fields($term_id)
{
    if (isset($_POST['mosalam_category_meta_nonce']) && wp_verify_nonce($_POST['mosalam_category_meta_nonce'], 'mosalam_save_category_meta')) {
        if (isset($_POST['mosalam_category_title'])) {
            update_term_meta($term_id, '_mosalam_category_title', sanitize_text_field(wp_unslash($_POST['mosalam_category_title'])));
        }
        if (isset($_POST['mosalam_category_hero_bg_id'])) {
            $bg_id = absint($_POST['mosalam_category_hero_bg_id']);
            if ($bg_id) {
                update_term_meta($term_id, '_mosalam_category_hero_bg_id', $bg_id);
            } else {
                delete_term_meta($term_id, '_mosalam_category_hero_bg_id');
            }
        }
    }
}
add_action('created_project_category', 'mosalam_save_project_category_fields');
add_action('edited_project_category', 'mosalam_save_project_category_fields');

/* ──────────────────────────────────────────────
 * 4. Admin assets for the meta boxes and category fields.
 * ────────────────────────────────────────────── */
function mosalam_enqueue_project_admin_assets($hook)
{
    $screen = get_current_screen();
    $is_project_post = in_array($hook, ['post.php', 'post-new.php'], true) && $screen && 'project' === $screen->post_type;
    $is_project_cat = in_array($hook, ['edit-tags.php', 'term.php'], true) && $screen && 'project_category' === $screen->taxonomy;

    if (!$is_project_post && !$is_project_cat) {
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

/**
 * Redirect single project page requests to the projects archive page.
 */
function mosalam_redirect_single_project()
{
    if (is_singular('project')) {
        wp_safe_redirect(mosalam_get_projects_archive_url(), 301);
        exit;
    }
}
add_action('template_redirect', 'mosalam_redirect_single_project');

