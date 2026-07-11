<?php
/**
 * Security and upload settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ──────────────────────────────────────────────
 * 1. Allow SVG uploads in Media Library.
 * ────────────────────────────────────────────── */
function mosalam_enable_svg_upload( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'mosalam_enable_svg_upload' );

/* ──────────────────────────────────────────────
 * 2. Fix mime-type check for SVG on upload.
 * ────────────────────────────────────────────── */
function mosalam_svg_filetype_and_ext( $data, $file, $filename, $mimes ) {
    $filetype = wp_check_filetype( $filename, $mimes );

    if ( in_array( $filetype['ext'], array( 'svg', 'svgz' ), true ) ) {
        $data['ext']             = $filetype['ext'];
        $data['type']            = $filetype['type'];
        $data['proper_filename'] = $filename;
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'mosalam_svg_filetype_and_ext', 10, 4 );

/* ──────────────────────────────────────────────
 * 3. Display SVG thumbnails correctly in admin.
 * ────────────────────────────────────────────── */
function mosalam_svg_admin_css() {
    echo '<style>
        .attachment-266x266, .thumbnail img[src$=".svg"],
        td.media-icon img[src$=".svg"] {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action( 'admin_head', 'mosalam_svg_admin_css' );

/* ──────────────────────────────────────────────
 * 4. Disable Theme & Plugin File Editors.
 * ────────────────────────────────────────────── */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

/* ──────────────────────────────────────────────
 * 5. Bypass image cropping for SVG files.
 *
 * WordPress's crop-image AJAX handler (priority 1)
 * uses GD/Imagick which cannot process vectors.
 * We intercept at priority 0: if the attachment is
 * SVG we skip all raster processing and either set
 * the site-icon directly or return the attachment
 * data as-is for any other Customizer context.
 * ────────────────────────────────────────────── */
function mosalam_bypass_svg_crop() {
    /* Bail early if no attachment ID was sent. */
    if ( empty( $_POST['id'] ) ) {
        return;
    }

    $attachment_id = absint( $_POST['id'] );

    /* Only act on SVG attachments. */
    if ( 'image/svg+xml' !== get_post_mime_type( $attachment_id ) ) {
        return;
    }

    /* Security: verify nonce + capability (same checks WP core does). */
    check_ajax_referer( 'image_editor-' . $attachment_id, 'nonce' );
    if ( ! current_user_can( 'edit_post', $attachment_id ) ) {
        wp_send_json_error();
    }

    $context = isset( $_POST['context'] )
        ? str_replace( '_', '-', sanitize_text_field( $_POST['context'] ) )
        : '';

    /* ── Site Icon context ────────────────────── */
    if ( 'site-icon' === $context ) {
        update_option( 'site_icon', $attachment_id );
    }

    /* Return attachment data and die — this prevents
       the core wp_ajax_crop_image handler from running. */
    wp_send_json_success( wp_prepare_attachment_for_js( $attachment_id ) );
}
add_action( 'wp_ajax_crop-image', 'mosalam_bypass_svg_crop', 0 );

/* ──────────────────────────────────────────────
 * 6. Prevent WordPress from trying to generate
 *    intermediate image sizes for SVG uploads.
 *    (Avoids GD/Imagick errors during upload.)
 * ────────────────────────────────────────────── */
function mosalam_svg_upload_metadata( $metadata, $attachment_id ) {
    $mime = get_post_mime_type( $attachment_id );
    if ( 'image/svg+xml' !== $mime ) {
        return $metadata;
    }

    $svg_path = get_attached_file( $attachment_id );

    /* Try to read real dimensions from the SVG markup. */
    $width  = 512;
    $height = 512;
    if ( file_exists( $svg_path ) ) {
        $svg = @simplexml_load_file( $svg_path );
        if ( $svg ) {
            $attrs = $svg->attributes();
            if ( isset( $attrs->viewBox ) ) {
                $parts = preg_split( '/[\s,]+/', (string) $attrs->viewBox );
                if ( count( $parts ) === 4 ) {
                    $width  = (int) round( (float) $parts[2] );
                    $height = (int) round( (float) $parts[3] );
                }
            }
            if ( isset( $attrs->width ) ) {
                $width = (int) round( (float) $attrs->width );
            }
            if ( isset( $attrs->height ) ) {
                $height = (int) round( (float) $attrs->height );
            }
        }
    }

    return array(
        'width'  => $width,
        'height' => $height,
        'file'   => _wp_relative_upload_path( $svg_path ),
    );
}
add_filter( 'wp_generate_attachment_metadata', 'mosalam_svg_upload_metadata', 10, 2 );
